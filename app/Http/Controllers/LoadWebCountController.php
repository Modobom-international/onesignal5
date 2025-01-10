<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoadWebCountStoreRequest;
use App\Repositories\LoadWebCountRepository;
use App\Http\Controllers\AppBaseController;

class LoadWebCountController extends AppBaseController
{
    /** @var  LoadWebCountRepository */
    private $loadWebCountRepository;

    public function __construct(LoadWebCountRepository $loadWebCountRepo)
    {
        $this->loadWebCountRepository = $loadWebCountRepo;
    }

    public function index()
    {
        $query = \DB::table('load_web_counts')->orderByDesc('id');
        $links = $query->paginate(env('PAGINATION_PER_PAGE', 100));

        return view('load_web_counts.index')
            ->with('loadWebCounts', $links);
    }

    public function create()
    {
        return view('load_web_counts.create');
    }

    public function store(LoadWebCountStoreRequest $request)
    {
        $input = $request->all();

        $this->loadWebCountRepository->create($input);

        return redirect(route('loadWebCounts.index'))->with('alert-success', 'Load Web Count saved successfully.');
    }

    public function show($id)
    {
        $loadWebCount = $this->loadWebCountRepository->find($id);

        if (empty($loadWebCount)) {
            return redirect(route('loadWebCounts.index'))->with('alert-error', 'Load Web Count not found');
        }

        return view('load_web_counts.show')->with('loadWebCount', $loadWebCount);
    }

    public function edit($id)
    {
        $loadWebCount = $this->loadWebCountRepository->find($id);

        if (empty($loadWebCount)) {
            return redirect(route('loadWebCounts.index'))->with('alert-error', 'Load Web Count not found');
        }

        return view('load_web_counts.edit')->with('loadWebCount', $loadWebCount);
    }

    public function update($id, LoadWebCountStoreRequest $request)
    {
        $loadWebCount = $this->loadWebCountRepository->find($id);

        if (empty($loadWebCount)) {
            return redirect(route('loadWebCounts.index'))->with('alert-error', 'Load Web Count not found');
        }

        $loadWebCount = $this->loadWebCountRepository->update($request->all(), $id);
        $game = $request->get('game');
        $dateNow = date('Y-m-d');
        $key = 'cache_' . $game . '_' . $dateNow;
        \Cache::store('redis')->forget($key);

        return redirect(route('loadWebCounts.index'))->with('alert-success', 'Load Web Count updated successfully.');
    }

    public function destroy($id)
    {
        $loadWebCount = $this->loadWebCountRepository->find($id);

        if (empty($loadWebCount)) {
            return redirect(route('loadWebCounts.index'))->with('alert-error', 'Load Web Count not found');
        }

        $this->loadWebCountRepository->delete($id);

        return redirect(route('loadWebCounts.index'))->with('alert-success', 'Load Web Count deleted successfully.');
    }
}
