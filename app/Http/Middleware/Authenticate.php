// app/Http/Middleware/Authenticate.php
public function handle($request, Closure $next, ...$guards)
{
    $this->authenticate($request, $guards);

    if (! $request->user()->valide) {
        auth()->logout();
        return redirect()->route('login')->withErrors([
            'email' => 'Votre compte n\'a pas encore été validé par l\'administrateur.',
        ]);
    }

    return $next($request);
}
