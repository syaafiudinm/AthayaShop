@if (Session::has('success')) 
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
        <span class="font-medium">Success alert!</span> {{Session::get('success')}}
    </div>
@endif

@if (Session::has('error'))
    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
        <span class="font-medium">Danger alert!</span> {{Session::get('error')}}
    </div>
@endif