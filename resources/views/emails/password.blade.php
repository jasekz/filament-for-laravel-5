@if(\Route::current()->getName() == 'admin.password.forgot_password')
    
    Click here to reset your password: {{ route('admin.password.reset_password', $token) }}
    
@else
    
    Click here to reset your password: {{ route('admin.password.reset_password', $token) }}
    
@endif


