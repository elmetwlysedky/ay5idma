<?php

namespace App\Http\Controllers\Api;

use App\Http\Services\NotificationService;
use Illuminate\Routing\Controller;
use App\Http\Services\AuthService;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\UserRequest;
use App\Http\Requests\Web\ForgotPasswordRequest;
use Carbon\Carbon;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use Password;
use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\HttpFoundation\Request;
use Illuminate\Http\Request;
use App\Models\User ;
use Lcobucci\JWT\Parser;
use App\Http\Requests\Api\UpdatePasswordRequest ;

use Auth ;

class AuthController extends Controller
{
    public $authService ;

    public function __Construct(AuthService $authService)
    {
        $this->authService = $authService ;
    }

    public function register(RegisterRequest $request, NotificationService $notificationService)
    {

        $user = $this->authService->registerFromRequest($request);

        $sms = $notificationService->sendSMS($user, $user->phone_verify);

        return response()->json([$user, $sms]);
    }

    public function login(LoginRequest $request)
    {

        $clientId = config('services.passport.client_id');
        $clientSecret = config('services.passport.client_secret');

        if ($clientId && $clientSecret) {
            return $this->issuePassportToken($request, $clientId, $clientSecret);
        }

        if (!$this->authService->attempt($request)) {
            return response()->json(['error' => trans('invalid_credentials')], Response::HTTP_UNAUTHORIZED);
        }

        /** @var User $user */
        $user = auth()->user();
        $tokenResult = $user->createToken('User Personal Token #' . $user->id);

        if (!$user->token || $user->token_expires_at < Carbon::now()) {
            $user->token = $tokenResult->accessToken;
            $user->token_expires_at = $tokenResult->token->expires_at;
            $user->save();
        }

        return response()->json([
            'token_type'   => 'Bearer',
            'access_token' => $tokenResult->accessToken,
            'expires_at'   => $tokenResult->token->expires_at,
            'user'         => $user,
        ]);
    }

    protected function issuePassportToken(LoginRequest $request, $clientId, $clientSecret)
    {
        $http = new HttpClient;

        try {
            $response = $http->post(url('/oauth/token'), [
                'form_params' => [
                    'grant_type'    => 'password',
                    'client_id'     => $clientId,
                    'client_secret' => $clientSecret,
                    'username'      => $request->input('email'),
                    'password'      => $request->input('password'),
                    'scope'         => '',
                ],
            ]);

            return response()->json(json_decode((string) $response->getBody(), true));
        } catch (ClientException $exception) {
            return response()->json(['error' => trans('invalid_credentials')], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function logout(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthenticated'], Response::HTTP_UNAUTHORIZED);
        }

        $token = $request->user()->token();
        if ($token) {
            $token->revoke();
        }

        return response()->json(['result' => 'Logged Out'], Response::HTTP_OK);
    }

    public function update(UserRequest $request)
    {
        User::where('id', auth()->user()->id)->update($request->all());

        return response(['success' => true], Response::HTTP_CREATED);
    }

    public function resetPassword(ForgotPasswordRequest $request)
    {
        Password::broker()->sendResetLink(
            $request->only('email')
        );

        return response(['success' => true], Response::HTTP_CREATED);
    }

    public function passwordUpdate(UpdatePasswordRequest $request)
    {
        return $this->authService->passwordUpdate($request) ;
    }
}
