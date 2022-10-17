
<nav {{ $attributes->merge(['class' => 'navbar navbar-expand-lg position-absolute top-0 z-index-3']) }}>
<div class="container {{ in_array(request()->route()->getName(),['illustration-sign-up','illustration-sign-in','illustration-reset','illustration-verification','illustration-lock','cover-lock','cover-sign-up']) ? 'ps-2 pe-0' : '' }}">

    <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 d-flex flex-column {{ in_array(request()->route()->getName(),['illustration-sign-up','illustration-sign-in','illustration-reset','illustration-verification','illustration-lock']) ? '' : 'text-white' }}" href="{{ route('analytics') }}">
    {{config('app.name')}}
   </a>

    <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation"
        aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon mt-2">
            <span class="navbar-toggler-bar bar1"></span>
            <span class="navbar-toggler-bar bar2"></span>
            <span class="navbar-toggler-bar bar3"></span>
        </span>
    </button>
    
</div>
</nav>
