<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Models\User;
use App\Models\loginLog;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
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
        $companyId=$request->session()->get('companyId')==null ? 1 : $request->session()->get('companyId');
        $log_obj=new loginLog;
        $log_obj->setDatabaseByCompanyId($companyId);
        //Check user logged in or not
        if(!Auth::check())
        {
            return redirect()->action(
                [AuthController::class, 'login'], ['errorMsg' =>'Please log in to access this page.','companyId'=>$companyId]
            );
        }
          /*Session activity BEGIN */
        $user_obj=new User;
        $session_details=$user_obj->getLastActivityDateTime( Auth::user()->id);
        if($session_details!=null)
        {
            if($session_details->sessionId!=$request->session()->get('user_sessionId'))
            {
                return redirect()->action(
                    [AuthController::class, 'login'], ['errorMsg' =>'Another user using this account. Please logout and try.','companyId'=>$companyId]
                );
            }
        }
        /*Session activity END */

        //Get the user details By tokenable_id
        $token_details= PersonalAccessToken::where('tokenable_id', Auth::user()->id)->get();
        if($token_details==null || $token_details->count()==0)
        {
            return redirect()->action(
                [AuthController::class, 'login'],['errorMsg' =>'Unauthorized Access. Please log in to access this page.','companyId'=>$companyId]
            );
        }
        //Check the token exist or not -- BEGIN
        $chk_token=false;
        $split_token=explode("|",$request->session()->get('prjtoken'));
        $expires_at= Carbon::now();
        if(count($split_token)!=2){
            return redirect()->action(
                [AuthController::class, 'login'], ['errorMsg' =>'Unauthorized Access.Please log in to access this page.1','companyId'=>$companyId]
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
                [AuthController::class, 'login'], ['errorMsg' =>'Unauthorized Access.Please log in to access this page.2','companyId'=>$companyId]
            );
        }
        //Check the token exist or not -- END
        //Check the expires_at is exited or not
        $date1=Carbon::NOW();
        $date2 = Carbon::parse($expires_at);
        $totalDuration = $date1->lt($date2);
        if (!$totalDuration) {
            return redirect()->action(
                [AuthController::class, 'login'], ['errorMsg' =>'Session expired. Please login again.','companyId'=>$companyId]
            );
        }
        // $loginLog=new loginLog;
        $id=Auth::user()->id;
        // $url = url()->current();
        // $loginLog->addLoginLog($id,$url);
      
        $isSet=1;
        $request->session()->put('isSetDefault', $isSet);
        if(Auth::user()->user_type_id==1)
        {
            if(Auth::user()->defaultHospitalId==0||Auth::user()->defaultHospitalId==null)
            {
                $isSet=0;
                $request->session()->put('isSetDefault', $isSet);
            }
        }
        return $next($request);
    }
}
