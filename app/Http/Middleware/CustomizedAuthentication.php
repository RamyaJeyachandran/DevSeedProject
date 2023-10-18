<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class CustomizedAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //Check user logged in or not
        if(!Auth::check())
        {
            return redirect()->action(
                [AuthController::class, 'login'], ['errorMsg' =>'Please log in to access this page.']
            );
        }
        //Get the user details By tokenable_id
        $token_details= PersonalAccessToken::where('tokenable_id', Auth::user()->id)->get();
        if($token_details==null || $token_details->count()==0)
        {
            return redirect()->action(
                [AuthController::class, 'login'], ['errorMsg' =>'Unauthorized Access. Please log in to access this page.']
            );
        }
        //Check the token exist or not -- BEGIN
        $chk_token=false;
        $split_token=explode("|",$request->session()->get('prjtoken'));
        $expires_at= Carbon::now();
        if(count($split_token)!=2){
            return redirect()->action(
                [AuthController::class, 'login'], ['errorMsg' =>'Unauthorized Access.Please log in to access this page.']
            );
        }
        $token_decrypt=hash('sha256', $split_token[1]); // Encrypt to check the token
        foreach ($token_details as $tdetails) {
            if ( $tdetails->token==$token_decrypt)
            {
                 $chk_token=true;
                 $expires_at=$tdetails->expires_at;
            }
        };

        if(!$chk_token){
            return redirect()->action(
                [AuthController::class, 'login'], ['errorMsg' =>'Unauthorized Access.Please log in to access this page.']
            );
        }
        //Check the token exist or not -- END
        //Check the expires_at is exited or not
        $date1=Carbon::NOW();
        $date2 = Carbon::parse($expires_at);
        $totalDuration = $date1->lt($date2);
        if (!$totalDuration) {
            return redirect()->action(
                [AuthController::class, 'login'], ['errorMsg' =>'Session expired. Please login again.']
            );
        }
        return $next($request);
    }
}
