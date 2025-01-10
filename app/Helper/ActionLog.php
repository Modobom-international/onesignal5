<?php


namespace App\Helper;


class ActionLog
{
    const ACTION_ADD_APK = 'Add apk';
    const ACTION_EDIT_APK = 'Edit apk';
    const ACTION_DELETE_APK = 'Delete apk';
    const ACTION_UPLOAD_APK = 'Upload apk file';

    const ACTION_ADD_LANDING_PAGE = 'Add landing page';
    const ACTION_EDIT_LANDING_PAGE = 'Edit landing page';
    const ACTION_DELETE_LANDING_PAGE = 'Delete landing page';
    const ACTION_SWITCH_LINK_LANDING_PAGE = 'Switch link landing page';
    const ACTION_EDIT_LINK_ACTIVE_LANDING = 'Edit link active landing page';
    const ACTION_SWITCH_VIEW_PAGE_LANDING_PAGE = 'Switch view page landing page';

    public function log($action, array $data)
    {
        try {

            \DB::table('action_logs')->insert([
                'action' => $action,
                'detail' => json_encode($data),
                'created_at' => Common::getCurrentVNTime(),
                'created_at_utc' => Common::getCurrentTime(),

            ]);

        } catch (\Exception $ex) {

        }

    }

}
