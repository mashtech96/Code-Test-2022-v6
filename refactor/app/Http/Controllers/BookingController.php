<?php

namespace DTApi\Http\Controllers;

use DTApi\Models\Job;
use DTApi\Http\Requests;
use DTApi\Models\Distance;
use Illuminate\Http\Request;
use DTApi\Repository\BookingRepository;

/**
 * Class BookingController
 * @package DTApi\Http\Controllers
 */
class BookingController extends Controller
{

    /**
     * @var BookingRepository
     */
    protected $repository;

    /**
     * BookingController constructor.
     * @param BookingRepository $bookingRepository
     */
    public function __construct(BookingRepository $bookingRepository)
    {
        $this->repository = $bookingRepository;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        try {
            if ($user_id = $request->get('user_id')) {

                $response = $this->repository->getUsersJobs($user_id);
            } elseif ($request->__authenticatedUser->user_type == env('ADMIN_ROLE_ID') || $request->__authenticatedUser->user_type == env('SUPERADMIN_ROLE_ID')) {
                $response = $this->repository->getAll($request);
            }
            return successResponse(config("constants.SUCCESS_TO_KEY_TO_GIVE"), $response);
        } catch (\Exception $e) {
            //or $e->getMessage() if you want to get exact error
            return errorResponse(config("constants.ERROR_TO_KEY_TO_GIVE"));
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        try {
            $job = $this->repository->with('translatorJobRel.user')->find($id);

            return succesResponse(config("constants.SUCCESS_TO_KEY_TO_GIVE"), $job);
        } catch (\Exception $e) {
            //or $e->getMessage() if you want to get exact error
            return errorResponse(config("constants.ERROR_TO_KEY_TO_GIVE"));
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        try {
            $data        = array();
            $data['abc'] =  $request->get('abc');
            $data['xyz'] =  $request->get('xyz');

            $response = $this->repository->store($request->__authenticatedUser, $data);

            return successResponse(config("constants.SUCCESS_TO_KEY_TO_GIVE"), $response);
        } catch (\Exception $e) {
            //or $e->getMessage() if you want to get exact error
            return errorResponse(config("constants.ERROR_TO_KEY_TO_GIVE"));
        }
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function update($id, Request $request)
    {
        try {
            $data        = array();
            $data['abc'] =  $request->get('abc');
            $data['xyz'] =  $request->get('xyz');
            $cuser = $request->__authenticatedUser;
            $response = $this->repository->updateJob($id, array_except($data, ['_token', 'submit']), $cuser);

            return successResponse(config("constants.SUCCESS_TO_KEY_TO_GIVE"), $response);
        } catch (\Exception $e) {
            //or $e->getMessage() if you want to get exact error
            return errorResponse(config("constants.ERROR_TO_KEY_TO_GIVE"));
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function immediateJobEmail(Request $request)
    {
        try {
            $adminSenderEmail = config('app.adminemail');
            $data        = array();
            $data['abc'] =  $request->get('abc');
            $data['xyz'] =  $request->get('xyz');

            $response = $this->repository->storeJobEmail($data);

            return successResponse(config("constants.SUCCESS_TO_KEY_TO_GIVE"), $response);
        } catch (\Exception $e) {
            //or $e->getMessage() if you want to get exact error
            return errorResponse(config("constants.ERROR_TO_KEY_TO_GIVE"));
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getHistory(Request $request)
    {
        try {
            ini_set('max_execution_time', 0);
            if ($user_id = $request->get('user_id')) {

                $response = $this->repository->getUsersJobsHistory($user_id, $request);
                return successResponse(config("constants.SUCCESS_TO_KEY_TO_GIVE"), $response);
            }
            return errorResponse(null);
        } catch (\Exception $e) {
            //or $e->getMessage() if you want to get exact error
            return errorResponse(config("constants.ERROR_TO_KEY_TO_GIVE"));
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function acceptJob(Request $request)
    {
        try {
            $data        = array();
            $data['abc'] =  $request->get('abc');
            $data['xyz'] =  $request->get('xyz');
            $user = $request->__authenticatedUser;

            $response = $this->repository->acceptJob($data, $user);

            return successResponse($response);
        } catch (\Exception $e) {
            //or $e->getMessage() if you want to get exact error
            return errorResponse(config("constants.ERROR_TO_KEY_TO_GIVE"));
        }
    }

    public function acceptJobWithId(Request $request)
    {
        try {
            $data = $request->get('job_id');
            $user = $request->__authenticatedUser;

            $response = $this->repository->acceptJobWithId($data, $user);

            return successResponse(config("constants.ERROR_TO_KEY_TO_GIVE"), $response);
        } catch (\Exception $e) {
            //or $e->getMessage() if you want to get exact error
            return errorResponse(config("constants.ERROR_TO_KEY_TO_GIVE"));
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function cancelJob(Request $request)
    {
        try {
            $data        = array();
            $data['abc'] =  $request->get('abc');
            $data['xyz'] =  $request->get('xyz');
            $user = $request->__authenticatedUser;

            $response = $this->repository->cancelJobAjax($data, $user);

            return successResponse(config("constants.SUCESS_TO_KEY_TO_GIVE"), $response);
        } catch (\Exception $e) {
            //or $e->getMessage() if you want to get exact error
            return errorResponse(config("constants.ERROR_TO_KEY_TO_GIVE"));
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function endJob(Request $request)
    {
        try {
            $data        = array();
            $data['abc'] =  $request->get('abc');
            $data['xyz'] =  $request->get('xyz');

            $response = $this->repository->endJob($data);

            return successResponse(config("constants.SUCESS_TO_KEY_TO_GIVE"), $response);
        } catch (\Exception $e) {
            //or $e->getMessage() if you want to get exact error
            return errorResponse(config("constants.ERROR_TO_KEY_TO_GIVE"));
        }
    }

    public function customerNotCall(Request $request)
    {
        try {
            $data        = array();
            $data['abc'] =  $request->get('abc');
            $data['xyz'] =  $request->get('xyz');

            $response = $this->repository->customerNotCall($data);

            return successResponse(config("constants.SUCCESS_TO_KEY_TO_GIVE"), $response);
        } catch (\Exception $e) {
            //or $e->getMessage() if you want to get exact error
            return errorResponse(config("constants.ERROR_TO_KEY_TO_GIVE"));
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getPotentialJobs(Request $request)
    {
        try {
            ini_set('max_execution_time', 0);
            $user = $request->__authenticatedUser;

            $response = $this->repository->getPotentialJobs($user);

            return successResponse(config("constants.SUCCESS_TO_KEY_TO_GIVE"), $response);
        } catch (\Exception $e) {
            //or $e->getMessage() if you want to get exact error
            return errorResponse(config("constants.ERROR_TO_KEY_TO_GIVE"));
        }
    }

    public function distanceFeed(Request $request)
    {
        try {
            $data        = array();
            $data['abc'] =  $request->get('abc');
            $data['xyz'] =  $request->get('xyz');

            if (isset($data['distance']) && $data['distance'] != "") {
                $distance = $data['distance'];
            } else {
                $distance = "";
            }
            if (isset($data['time']) && $data['time'] != "") {
                $time = $data['time'];
            } else {
                $time = "";
            }
            if (isset($data['jobid']) && $data['jobid'] != "") {
                $jobid = $data['jobid'];
            }

            if (isset($data['session_time']) && $data['session_time'] != "") {
                $session = $data['session_time'];
            } else {
                $session = "";
            }

            if ($data['flagged'] == 'true') {
                if ($data['admincomment'] == '') return "Please, add comment";
                $flagged = 'yes';
            } else {
                $flagged = 'no';
            }

            if ($data['manually_handled'] == 'true') {
                $manually_handled = 'yes';
            } else {
                $manually_handled = 'no';
            }

            if ($data['by_admin'] == 'true') {
                $by_admin = 'yes';
            } else {
                $by_admin = 'no';
            }

            if (isset($data['admincomment']) && $data['admincomment'] != "") {
                $admincomment = $data['admincomment'];
            } else {
                $admincomment = "";
            }
            if ($time || $distance) {

                $affectedRows = Distance::where('job_id', '=', $jobid)->update(array('distance' => $distance, 'time' => $time));
            }

            if ($admincomment || $session || $flagged || $manually_handled || $by_admin) {

                $affectedRows1 = Job::where('id', '=', $jobid)->update(array('admin_comments' => $admincomment, 'flagged' => $flagged, 'session_time' => $session, 'manually_handled' => $manually_handled, 'by_admin' => $by_admin));
            }

            return successResponse(config("constants.SUCESS_TO_KEY_TO_GIVE"), []);
        } catch (\Exception $e) {
            //or $e->getMessage() if you want to get exact error
            return errorResponse(config("constants.ERROR_TO_KEY_TO_GIVE"));
        }
    }

    public function reopen(Request $request)
    {
        try {
            $data        = array();
            $data['abc'] =  $request->get('abc');
            $data['xyz'] =  $request->get('xyz');
            $response = $this->repository->reopen($data);

            return successResponse(config("constants.SUCESS_TO_KEY_TO_GIVE"), $response);
        } catch (\Exception $e) {
            //or $e->getMessage() if you want to get exact error
            return errorResponse(config("constants.ERROR_TO_KEY_TO_GIVE"));
        }
    }

    public function resendNotifications(Request $request)
    {
        try {
            $data        = array();
            $data['abc'] =  $request->get('abc');
            $data['xyz'] =  $request->get('xyz');
            $job = $this->repository->find($data['jobid']);
            $job_data = $this->repository->jobToData($job);
            $this->repository->sendNotificationTranslator($job, $job_data, '*');

            return successResponse(config("constants.SUCCESS_TO_KEY_TO_GIVE"));
        } catch (\Exception $e) {
            //or $e->getMessage() if you want to get exact error
            return errorResponse(config("constants.ERROR_TO_KEY_TO_GIVE"));
        }
    }

    /**
     * Sends SMS to Translator
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function resendSMSNotifications(Request $request)
    {
        try {
            $data        = array();
            $data['abc'] =  $request->get('abc');
            $data['xyz'] =  $request->get('xyz');

            $job = $this->repository->find($data['jobid']);
            $job_data = $this->repository->jobToData($job);
            $this->repository->sendSMSNotificationToTranslator($job);
            return successResponse(config("constants.SUCCESS_TO_KEY_TO_GIVE"));
        } catch (\Exception $e) {
            //or $e->getMessage() if you want to get exact error
            return errorResponse(config("constants.ERROR_TO_KEY_TO_GIVE"));
        }
    }
}
