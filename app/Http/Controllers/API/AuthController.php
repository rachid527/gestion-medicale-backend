<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateUserRequest;

class AuthController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth:api', ['except' => ['login']]);
    }



    // Inscription d’un patient (JWT)
    // public function register(Request $request)
    // {
    //     $validated = $request->validate([
    //         'nom' => 'required|string',
    //         'prenom' => 'required|string',
    //         'email' => 'required|email|unique:utilisateurs',
    //         'mot_de_passe' => 'required|min:6|confirmed', // Confirmé = mot_de_passe_confirmation
    //         'telephone' => 'nullable|string',
    //         'adresse' => 'nullable|string',
    //         'sexe' => 'required|in:Homme,Femme',
    //         'date_naissance' => 'nullable|date',
    //     ]);


    //     // Hachage du mot de passe
    //     $validated['mot_de_passe'] = Hash::make($validated['mot_de_passe']);
    //     $validated['role'] = 'patient'; // Par défaut
    //     $validated['statut'] = 'actif';
    //     dd($validated);

    //     $utilisateur = Utilisateur::create($validated);

    //     return response()->json([
    //         'message' => 'Inscription réussie',
    //         'user' => $utilisateur
    //     ], 201);
    // }



    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = Auth::attempt($credentials)) {
            // dd($credentials);
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(Auth::user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth::refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth::factory()->getTTL() * 60
        ]);
    }


    public function register(CreateUserRequest $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($request->password);

        dd($input);

        $user = User::create($input);

        return response()->json([
            'success' => true,
            'message' => "Thank's! You are successfully registered",
            'user' => $user
        ], 201);
    }
}
