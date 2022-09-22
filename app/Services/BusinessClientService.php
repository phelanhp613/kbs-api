<?php

namespace App\Services;

use App\Repositories\BusinessClientRepository;
use Exception;
use App\Email\EmailServiceInterface;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use App\Repositories\UserRepository;

class BusinessClientService extends AbstractService
{
    protected $sentry;
    protected $userRepository;
    protected $businessClientRepository;
    protected $emailServiceInterface;

    public function __construct(
        BusinessClientRepository $businessClientRepository,
        EmailServiceInterface $emailServiceInterface,
        UserRepository $userRepository
    ) {
        $this->sentry = app('sentry');
        $this->businessClientRepository = $businessClientRepository;
        $this->emailServiceInterface = $emailServiceInterface;
        $this->userRepository = $userRepository;
    }

    public function list($request)
    {
        $this->setMessage(config('api-messages.error.common'));
        $this->setStatus(false);
        try {
            $data = $this->businessClientRepository->paginate($request->all());
            $this->setStatus(true);
            $this->setData($data);
            $this->setMessage(config('api-messages.success.common'));
        } catch (Exception $exception) {
            $sentryId = $this->sentry->captureException($exception);
            $this->setMessage('Get list business client err');
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
            $data = $this->businessClientRepository->create($request->all());
            $body = "<div>Company Name: $data->company_name</div>";
            $body .= "<div>Company Name Furi: $data->company_name_furi</div>";
            $body .= "<div>Client Pic Name: $data->client_pic_name</div>";
            $body .= "<div>Email: $data->client_pic_name</div>";
            $emailData = [
                'subject' => "Template Email  for Business",
                'body' => $body
            ];
            $emails = [];
            foreach ($this->userRepository->all() as $user){
                $emails[] = $user->email;
            }
            $this->emailServiceInterface->send($emails, $emailData, 'emails.business-client');
            DB::commit();
            $this->setStatus(true);
            $this->setData($data);
            $this->setMessage(config('api-messages.success.common'));
        } catch (QueryException $exception) {
            DB::rollback();
            $sentryId = $this->sentry->captureException($exception);
            $this->setMessage('Create business client err');
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
            $data = $this->businessClientRepository->updateById($id, $request->all());
            $this->setStatus(true);
            $this->setData($data);
            $this->setMessage(config('api-messages.success.common'));
        } catch (Exception $exception) {
            $sentryId = $this->sentry->captureException($exception);
            $this->setMessage('Update business client err');
            $this->setSentryId((string)$sentryId);
        }

        return $this;
    }

    public function delete($id)
    {
        $this->setMessage(config('api-messages.error.common'));
        $this->setStatus(false);
        try {
            $data = $this->businessClientRepository->deleteById($id);
            $this->setStatus(true);
            $this->setData($data);
            $this->setMessage(config('api-messages.success.common'));
        } catch (Exception $exception) {
            $sentryId = $this->sentry->captureException($exception);
            $this->setMessage('Delete business client err');
            $this->setSentryId((string)$sentryId);
        }

        return $this;
    }
}
