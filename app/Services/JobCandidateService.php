<?php

namespace App\Services;

use App\Repositories\JobCandidateRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use App\Email\EmailServiceInterface;
use App\Repositories\UserRepository;

class JobCandidateService extends AbstractService
{
    protected $sentry;
    protected $userRepository;
    protected $jobCandidateRepository;
    protected $emailServiceInterface;

    public function __construct(
        JobCandidateRepository $jobCandidateRepository,
        EmailServiceInterface $emailServiceInterface,
        UserRepository $userRepository
    ) {
        $this->sentry = app('sentry');
        $this->jobCandidateRepository = $jobCandidateRepository;
        $this->emailServiceInterface = $emailServiceInterface;
        $this->userRepository = $userRepository;
    }

    public function list($request)
    {
        $this->setMessage(config('api-messages.error.common'));
        $this->setStatus(false);
        try {
            $data = $this->jobCandidateRepository->paginate($request->all());
            $this->setStatus(true);
            $this->setData($data);
            $this->setMessage(config('api-messages.success.common'));
        } catch (Exception $exception) {
            $sentryId = $this->sentry->captureException($exception);
            $this->setMessage('Get list job candidate err');
            $this->setSentryId((string)$sentryId);
        }

        return $this;
    }

    public function create($request)
    {

        $this->setMessage(config('api-messages.error.common'));
        $this->setStatus(false);
        DB::beginTransaction();
        try {
            $data = $this->jobCandidateRepository->create($request->all());
            $body = "<div>Name: $data->name</div>";
            $body .= "<div>Phone: $data->phone</div>";
            $body .= "<div>Skill: $data->skill</div>";
            $emailData = [
                'subject' => "Template Email for Job Candidate",
                'body' => $body
            ];
            $emails = [];
            foreach ($this->userRepository->all() as $user){
                $emails[] = $user->email;
            }
            $this->emailServiceInterface->send($emails, $emailData, 'emails.job-candidate');
            DB::commit();
            $this->setStatus(true);
            $this->setData($data);
            $this->setMessage(config('api-messages.success.common'));
        }  catch (QueryException $exception) {
            DB::rollback();
            $sentryId = $this->sentry->captureException($exception);
            $this->setMessage('Create job candidate err');
            $this->setSentryId((string)$sentryId);
        } catch (Exception $exception) {
            DB::rollback();
            $sentryId = $this->sentry->captureException($exception);
            $this->setMessage('Cannot Send Mail');
            $this->setSentryId((string)$sentryId);
        }
        return $this;
    }

    public function update($id, $request)
    {
        $this->setMessage(config('api-messages.error.common'));
        $this->setStatus(false);
        try {
            $data = $this->jobCandidateRepository->updateById($id, $request->all());
            $this->setStatus(true);
            $this->setData($data);
            $this->setMessage(config('api-messages.success.common'));
        } catch (Exception $exception) {
            $sentryId = $this->sentry->captureException($exception);
            $this->setMessage('Update job candidate err');
            $this->setSentryId((string)$sentryId);
        }

        return $this;
    }

    public function delete($id)
    {
        $this->setMessage(config('api-messages.error.common'));
        $this->setStatus(false);
        try {
            $data = $this->jobCandidateRepository->deleteById($id);
            $this->setStatus(true);
            $this->setData($data);
            $this->setMessage(config('api-messages.success.common'));
        } catch (Exception $exception) {
            $sentryId = $this->sentry->captureException($exception);
            $this->setMessage('Delete job candidate err');
            $this->setSentryId((string)$sentryId);
        }

        return $this;
    }
}
