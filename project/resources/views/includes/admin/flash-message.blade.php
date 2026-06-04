<script>
@if ($message = Session::get('success'))
toastr.success(@json($message));
@endif
@if ($message = Session::get('error'))
toastr.error(@json($message));
@endif
@if ($message = Session::get('warning'))
toastr.warning(@json($message));
@endif
@if ($message = Session::get('info'))
toastr.info(@json($message));
@endif
@if ($errors->any())
toastr.error('Please check the form below for errors');
@endif
</script>
