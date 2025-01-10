<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorageFileRequest;
use App\Http\Requests\UpdateStorageFileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiStorageFileController extends Controller
{
    public function createFile()
    {
        return view('admin.storage-file.create');
    }
    public function storeFile(StorageFileRequest $request)
    {
        $input = $request->except(['_token']);
        $myFile = $input['url']->getClientOriginalName();
        $request->url->move(public_path('storage-file'), $myFile);
        $path = $request->getSchemeAndHttpHost() . "/" . 'storage-file/' . $myFile;
        $input['url'] = $myFile;
        $getApp = $input['app_id'];
        $file = 'file_app_' . $getApp . '.xml';
        $xmlString = Storage::disk('public_uploads')->exists($file) ? Storage::disk('public_uploads')->get($file) : '<?xml version="1.0"?><items></items>';
        $xml = new \SimpleXMLElement($xmlString);
        $newItem = $xml->addChild('item');
        $newItem->addChild('version', $input['version']);
        $newItem->addChild('url', $path);
        $newItem->addChild('changelog', $input['changelog']);
        $newItem->addChild('mandatory', $input['mandatory']);
        $newItem->addChild('app_id', $input['app_id']);

        Storage::disk('public_uploads')->put($file, $xml->asXML());
        \DB::table('storage_files')->insert($input);

        $response['message'] = "File được thêm thành công.";
        $response['success'] = "true";

        return redirect()->route('listFile')->with('message', 'File successfully created.');
    }

    public function listFile()
    {
        $files = \DB::table('storage_files')->orderBy('id', 'desc')->paginate(10);

        return view('admin.storage-file.file', ['files' => $files]);
    }

    public function showFile($id)
    {
        $mandatories = [
            'true' => 'True',
            'false' => 'False',
        ];
        $showFile = \DB::table('storage_files')->where('id', $id)->first();
        return view('admin.storage-file.show', compact('showFile', 'mandatories'));
    }

    public function editFile($id)
    {
        $mandatories = [
            'true' => 'True',
            'false' => 'False',
        ];
        $showFile = \DB::table('storage_files')->where('id', $id)->first();
        return view('admin.storage-file.edit', compact('showFile', 'mandatories'));
    }

    public function updateFile(UpdateStorageFileRequest $request, $id)
    {
        $data =  request()->except(['_token']);

        if ($request->hasFile('url')) {
            $url = $request->file('url');
            $destinationPath = 'storage-file';
            $myFile = $url->getClientOriginalName();
            $request->url->move(public_path($destinationPath), $myFile);
            $urlPath = $request->getSchemeAndHttpHost() . "/" . 'storage-file/' . $myFile;
            $data['url'] = $myFile;
        }
        $pathURL = $request->getSchemeAndHttpHost() . "/" . 'storage-file/' . $data['url'];

        $file = 'file_app_' . $data['app_id'] . '.xml';
        $xmlString = Storage::disk('public_uploads')->exists($file) ? Storage::disk('public_uploads')->get($file) : '<?xml version="1.0"?><items></items>';

        $xml = new \SimpleXMLElement($xmlString);
        $xml->item[0]->version =  $data['version'];
        $xml->item[0]->url =  $urlPath ?? $pathURL;
        $xml->item[0]->changelog =  $data['changelog'];
        $xml->item[0]->mandatory =  $data['mandatory'];
        $xml->item[0]->app_id =  $data['app_id'];

        Storage::disk('public_uploads')->put($file, $xml->asXML());

        $response['message'] = "File được thêm thành công.";
        $response['success'] = "true";
        \DB::table('storage_files')->where('id', $id)->update($data);

        return redirect()->route('listFile')->with('message', 'File successfully update.');
    }

    public function getFileXML($app)
    {
        $showFile = \DB::table('storage_files')->where('app_id', $app)->first();
        $fileApp = $showFile->app_id;

        return redirect()->route('showFileXML', ['fileApp' => $fileApp]);
    }

    public function showFileXML(Request $request)
    {
        $App = $request->fileApp;
        $file = 'file_app_' . $App . '.xml';
        $xmlString = file_get_contents(public_path('uploads/' . $file));
        $xmlObject = simplexml_load_string($xmlString);
        $json = json_encode($xmlObject);
        $phpArray = json_decode($json, true);
        $xml = new \SimpleXMLElement('<item/>');
        array_walk_recursive($phpArray, function ($value, $key) use ($xml) {
            $xml->addChild($key, htmlspecialchars($value));
        });

        $xmlString = $xml->asXML();

        return response($xmlString)->header('Content-Type', 'application/xml');
    }

    public function deleteFile($id)
    {
        \DB::table('storage_files')->where('id', $id)->delete();

        return redirect()->route('listFile')->with('message', 'File successfully delete.');
    }
}
