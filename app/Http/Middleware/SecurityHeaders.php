<?php
+
+namespace App\Http\Middleware;
+
+use Closure;
+use Illuminate\Http\Request;
+
+class SecurityHeaders
+{
+    /**
+     * Handle an incoming request.
+     *
+     * @param  \Illuminate\Http\Request  $request
+     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
+     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
+     */
+    public function handle(Request $request, Closure $next)
+    {
+        $response = $next($request);
+
+        // Prevents the page from being displayed in a frame (Clickjacking)
+        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
+
+        // Prevents the browser from MIME-sniffing a response away from the declared content-type
+        $response->headers->set('X-Content-Type-Options', 'nosniff');
+
+        // Enables the Cross-site scripting (XSS) filter built into most recent web browsers
+        $response->headers->set('X-XSS-Protection', '1; mode=block');
+
+        // Referrer-Policy controls how much referrer information the browser includes with navigations
+        $response->headers->set('Referrer-Policy', 'no-referrer-when-downgrade');
+
+        // Content-Security-Policy (Basic - can be tightened further based on needs)
+        // This is a conservative policy that allows assets from the same origin.
+        $response->headers->set('Content-Security-Policy', "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://fonts.googleapis.com https://cdn.jsdelivr.net; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.jsdelivr.net; font-src 'self' https://fonts.gstatic.com; img-src 'self' data:; frame-src 'self';");
+
+        return $response;
+    }
+}
+
