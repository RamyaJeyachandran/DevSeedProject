<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Models\User;
use App\Models\loginLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class ApiCustomizedAuthentication
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
            $result['error'] = 'Failure';
            $result['Success'] = 'Failure';
            $result['Message'] = 'Please log in to access this page.';
            $result['ShowModal'] = 2;
            return response()->json($result, 302);
        }
          /*Session activity BEGIN */
        $user_obj=new User;
        $session_details=$user_obj->getLastActivityDateTime( Auth::user()->id);
        if($session_details!=null)
        {
            if($session_details->sessionId!=$request->session()->get('user_sessionId'))
            {
                $result['error'] = 'Failure';
                $result['Success'] = 'Failure';
                $result['Message'] = 'Another user currently using this account. Please logout and try.';
                $result['ShowModal'] = 2;
                return response()->json($result, 302);
            }
        }
        /*Session activity END */

        //Get the user details By tokenable_id
        $token_details= PersonalAccessToken::where('tokenable_id', Auth::user()->id)->get();
        if($token_details==null || $token_details->count()==0)
        {
            $result['error'] = 'Failure';
            $result['Success'] = 'Failure';
            $result['Message'] = 'Unauthorized Access. Please log in to access this page.';
            $result['ShowModal'] = 2;
            return response()->json($result, 302);
        }
        //Check the token exist or not -- BEGIN
        $chk_token=false;
        $split_token=explode("|",$request->session()->get('prjtoken'));
        $expires_at= Carbon::now();
        if(count($split_token)!=2){
            $result['error'] = 'Failure';
            $result['Success'] = 'Failure';
            $result['Message'] = 'Unauthorized Access.Please log in to access this page.1';
            $result['ShowModal'] = 2;
            return response()->json($result, 302);
        }
        $token_decrypt=hash('sha256', $split_token[1]); // Encrypt to check the token
        foreach ($token_details as $tdetails) {
            if ( $tdetails->token==$token_decrypt)
            {
                 $chk_token=true;
                 $expires_at=$tdetails->expires_at;
            }
            $result['token']=$tdetails->token;
            $result['split_token']=$token_decrypt;
        };

        if(!$chk_token){
            $result['error'] = 'Failure';
            $result['Success'] = 'Failure';
           
            $result['Message'] = 'Unauthorized Access.Please log in to access this page.2';
            $result['ShowModal'] = 2;
            return response()->json($result, 302);
        }
        //Check the token exist or not -- END
        //Check the expires_at is exited or not
        $date1=Carbon::NOW();
        $date2 = Carbon::parse($expires_at);
        $totalDuration = $date1->lt($date2);
        if (!$totalDuration) {
            $result['error'] = 'Failure';
            $result['Success'] = 'Failure';
            $result['Message'] = 'Session expired. Please login again.';
            $result['ShowModal'] = 2;
            return response()->json($result, 302);
        }
        return $next($request);
    }
}
