<?php
namespace App\Http\Middleware;

 use Closure;
 use Illuminate\Support\Facades\Auth;
 use App\Models\User;

   class CheckToken
   {
       public function handle($request, Closure $next)
       {
           $token = $request->cookie('token');
          
           if (!$token) {
               return response()->json(['message' => 'Unauthorized'], 401);
           }

           $user = User::whereHas('tokens', function ($query) use ($token) {
               $query->where('name', 'auth_token')->where('token', hash('sha256', $token));
           })->first();
           
           dump($user);die;

           if (!$user) {
               return response()->json(['message' => 'Unauthorized'], 401);
           }

           Auth::login($user);

           return $next($request);
       }
   }
