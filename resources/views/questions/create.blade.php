@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">New Question</h4>
			</div>
			<div class="card-body">

					<div class="form-group row">
						<span class="col-12 col-lg-8 offset-lg-2">
							<input type="hidden" value="1" id="topic_id">
							<input type="text" id="ques" placeholder="Type your question here..." class="form-control">
						</span>
					</div>

					<div class="form-group row">
						<span class="col-10 offset-1 col-lg-6 offset-lg-3">
							<input type="text" id="opt_a" placeholder="Option A" class="form-control">
							<input type="text" id="opt_b" placeholder="Option B" class="form-control">
							<input type="text" id="opt_c" placeholder="Option C" class="form-control">
							<input type="text" id="opt_d" placeholder="Option D" class="form-control">
						</span>
					</div>
					<hr>
					<div class="form-group row">
						<span class="col-6 offset-3">
							<label for="">Correct Answer</label>
							<select id="ans" class="form-control">
								<option value="a">A</option>
								<option value="b">B</option>
								<option value="c">C</option>
								<option value="d">D</option>
							</select>
						</span>
					</div>
					<hr>
					<div class="form-group text-center">
						<button onclick="submit();" class="btn btn-success">Submit</button>
					</div>
			</div>
		</div>
	</div>
@endsection

@push('scripts')
<script>
	// $(document).ready(function(){
	// 	alert('test');
	// });

	function submit() {
		var options = {
				"a" : $('#opt_a').val(),
				"b" : $('#opt_b').val(),
				"c" : $('#opt_c').val(),
				"d" : $('#opt_d').val()
			};

		var postData = {
			'_token': '{{ csrf_token() }}',
			'ques': $('#ques').val(),
			'ans': $('#ans').val(),
			'topic_id': $('#topic_id').val(),
		  'options': JSON.stringify(options)
		}

		axios.post('/questions', postData).then(response => {
			console.log(response.data);
		}).catch(error => console.log(error.response.data));
	}

</script>
@endpush