<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use App\Repositories\UserRepository;
use Illuminate\Support\Str;

class UserService extends AbstractService
{
    protected $sentry;
    protected $userRepository;

    public function __construct(
        UserRepository $userRepository
    ) {
        $this->sentry = app('sentry');
        $this->userRepository = $userRepository;
    }

    public function list($params)
    {
        $this->setMessage(config('api-messages.error.common'));
        $this->setStatus(false);
        try {
            $data = $this->userRepository->paginate($params);
            $this->setStatus(true);
            $this->setData($data);
            $this->setMessage(config('api-messages.success.common'));
        } catch (\Exception $exception) {
            $sentryId = $this->sentry->captureException($exception);
            $this->setMessage("Get list user err");
            $this->setSentryId((string) $sentryId);
        }

        return $this;
    }

    public function create($params)
    {
        $this->setMessage(config('api-messages.error.common'));
        $this->setStatus(false);
        try {
            if(!empty($params['password']) && Hash::needsRehash($params['password'])) {
                $params['password'] = Hash::make($params['password']);
            }

            $params['integration_token'] = Str::uuid()->toString();
            $user = $this->userRepository->create($params);
            $this->setStatus(true);
            $this->setData([$user]);
            $this->setMessage(config('api-messages.success.common'));
        } catch (\Exception $exception) {
            $sentryId = $this->sentry->captureException($exception);
            $this->setMessage("Create user err");
            $this->setSentryId((string) $sentryId);
        }

        return $this;
    }
    public function logout($request)
    {
        $this->setMessage(config('api-messages.error.common'));
        $this->setStatus(false);
        try {
            $request->user()->currentAccessToken()->delete();
            $this->setStatus(true);
            $this->setData([]);
            $this->setMessage(config('api-messages.success.common'));
        } catch (\Exception $exception) {
            $sentryId = $this->sentry->captureException($exception);
            $this->setMessage("Logout err");
            $this->setSentryId((string) $sentryId);
        }
        return $this;
    }

    public function delete($id)
    {
        $this->setMessage(config('api-messages.error.common'));
        $this->setStatus(false);
        try {
            $data = $this->userRepository->deleteById($id);
            $this->setStatus(true);
            $this->setData($data);
            $this->setMessage(config('api-messages.success.common'));
        } catch (\Exception $exception) {
            $sentryId = $this->sentry->captureException($exception);
            $this->setMessage("Delete user err");
            $this->setSentryId((string) $sentryId);
        }

        return $this;
    }

    public function update($id, $params)
    {
        $this->setMessage(config('api-messages.error.common'));
        $this->setStatus(false);
        try {
            if(!empty($params['password']) && Hash::needsRehash($params['password'])) {
                $params['password'] = Hash::make($params['password']);
            }
            $data = $this->userRepository->updateById($id, $params);
            $this->setStatus(true);
            $this->setData($data);
            $this->setMessage(config('api-messages.success.common'));
        } catch (\Exception $exception) {
            $sentryId = $this->sentry->captureException($exception);
            $this->setMessage('Update user err');
            $this->setSentryId((string) $sentryId);
        }

        return $this;
    }

    public function profile($request)
    {
        $this->setMessage(config('api-messages.error.common'));
        $this->setStatus(false);
        try {
            $this->setStatus(true);
            $this->setData($request->user());
            $this->setMessage(config('api-messages.success.common'));
        } catch (\Exception $exception) {
            $sentryId = $this->sentry->captureException($exception);
            $this->setMessage('Get user by id err');
            $this->setSentryId((string) $sentryId);
        }

        return $this;
    }
}
