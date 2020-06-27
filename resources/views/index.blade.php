@extends('layout')
@section('content')
    <form method="POST" action="{{ route('check') }}">
        @csrf
        <div class="field">
            <label class="label" for="excerpt">Country</label>
            @error('country')
                <span class="alert text-danger">{{ $message }}</span>
            @enderror

            <div class="control">
                <select name="country" id="country" class="form-control" required placeholder="Select country">
                        <option value="">Select country</option>
                    @forelse ($countries as $countryCode => $countryName)
                        <option value="{{ $countryCode }}">{{ $countryName }}</option>
                    @empty
                        <option value="">No data loaded</option>
                    @endforelse
                </select>
            </div>
        </div>
        <div class="field">
            <label class="label" for="body">City</label>
            @error('city')
                <span class="alert text-danger">{{ $message }}</span>
            @enderror
            <div class="control">
                <select name="city" id="city" class="form-control" required placeholder="Select city">
                    <option value="">--</option>
                </select>
            </div>
        </div>
        <div class="field mt-5">
            <div class="control">
                <button class="btn btn-lg btn-primary btn-block" type="submit">Get Temperature</button>
            </div>
        </div>
    </form>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        const countrySelector = $('#country');
        const citySelector = $('#city');
        const defaultLoading = '<option value="">Loading...</option>';
        const foundNoData = '<option value="">Unable to load data</option>';

		// When a country is selected update cities select dropdown.
		countrySelector.on('change',() => {
            const country = countrySelector.val();
            var html = '';

            citySelector.find('option').remove();
            citySelector.append(defaultLoading);

            $.ajax({
                type:'GET',
                dataType: 'json',
                url: '{{ route('citiesByCountry') }}',
                data: {country:country},
                success: (result) => {
                    citySelector.find('option').remove();

                    if (Object.keys(result).length !== 0) {
                        for (var key in result) {
                            html += `<option value="${result[key]}">${result[key]}</option>`;
                        }
                        citySelector.append(html);
                    }
                    else {
                        citySelector.append(foundNoData);
                    }
                }
            });
        });

        // Check for any selected county on load
        window.onload = function(e){
            if( countrySelector.val() != '' ){
                countrySelector.trigger('change');
            }
        };
	</script>
@endsection
