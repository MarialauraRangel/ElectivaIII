@if (session('alert')=="lobibox" && session('type') && session('title') && session('msg'))
<script type="text/javascript">
	Lobibox.notify('{{ session('type') }}', {
		title: '{{ session('title') }}',
		sound: true,
		msg: '{{ session('msg') }}'
	});
</script>
@elseif (session('alert')=="sweet" && session('type') && session('title') && session('msg'))
<script type="text/javascript">
	swal({
      title: '{{ session('title') }}',
      text: "{{ session('msg') }}",
      type: '{{ session('type') }}',
      padding: '2em'
    })
</script>
@endif