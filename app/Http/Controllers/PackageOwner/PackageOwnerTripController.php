<?php

namespace App\Http\Controllers\PackageOwner;

use App\Entities\RequestShip;
use App\Entities\RequestTracking;
use App\Http\Controllers\ApiController;
use App\Traits\FirebaseConnection;
use App\Traits\SMSTrait;
use App\Traits\UpdateRequestTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackageOwnerTripController extends ApiController
{
    use UpdateRequestTracking;
    use SMSTrait;
    use FirebaseConnection;

    public function update(Request $request, $requestShipId)
    {
        $rules = [
            'otp_code' => 'required|string',
        ];

        $this->validate($request, $rules);

        $data = $request->all();

        $requestShip = RequestShip::findOrFail($requestShipId);
        $requestShipOwner = $requestShip->user()->first();

        // Check verified package owner code before verifying OTP code
        if (!$requestShip->isVerifiedPOCode()) {
            $message = array(
                'success' => false,
                'message' => "Please verify package owner code before verifying OTP code",
                'code' => 403
            );
            return response()->json($message, 403);
        }

        // Verify code sent
        $response = $this->verifyCodeSent($requestShipOwner->phone, $data['otp_code']);
        $responseObject = json_decode($response);
        if (!$responseObject->success) {
            $message = array(
                'success' => false,
                'message' => $responseObject->message,
                'code' => 403
            );
            return response()->json($message, 403);
        }

        // Send verification code to receiver
        $receiverPhone = $requestShip->receiver_phone;
        $receiverCode = $requestShip->receiver_verification_code;

        $response = $this->sendNormalSMS($receiverPhone, $receiverCode);
        $responseObject = json_decode($response);
        if (!$responseObject->success) {
            $message = array(
                'success' => false,
                'message' => $responseObject->message,
                'code' => $responseObject->code
            );
            return response()->json($message, $responseObject->code);
        }

        // Update status of OTP code
        $requestShip->otp_code = RequestShip::VERIFIED_OTP;
        $requestShip->save();

        // Prepare data for request tracking before insert
        $status = RequestTracking::DELIVERING_TRIP;
        $this->updateRequestTracking($requestShipOwner->id, $requestShip->id, $status);

        // Update request ship status on firebase
        $path = "package/package-owner/{$requestShipOwner->id}/{$requestShip->id}/status";
        $this->saveData($path, $status);

        $shipperId = $requestShip->trip()->first()->shipper_id;
        $path = "package/shipper/{$shipperId}/{$requestShip->id}/status";
        $this->saveData($path, $status);

        $message = array(
            'success' => true,
            'message' => 'The request ship was confirmed by yourself successfully',
            'code' => 200
        );
        return response()->json($message, 200);
    }
}
