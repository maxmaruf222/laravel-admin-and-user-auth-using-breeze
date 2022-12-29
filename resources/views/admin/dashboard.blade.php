admin logged in 

<br>
<form action="{{ route('admin.logout') }}" method="POST">
    @csrf
    <button type="submit">admin log out</button>
</form>
