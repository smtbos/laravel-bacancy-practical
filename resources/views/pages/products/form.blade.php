@csrf
<div class="form-group mb-3">
    <label for="name">Name</label>
    <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $product->name ?? '') }}">
    @if ($errors->has('name'))
        <div class="invalid-feedback d-block">
            {{ $errors->first('name') }}
        </div>
    @endif
</div>
<div class="row">
    <div class="col-12"><label for="name">Lots</label></div>
    <div class="col-12" id="lots">
        @foreach (old('lots', $product->lots ?? [['quantity' => '', 'expiry_date' => '']]) as $key => $lot)
            <div class="row mb-3 lot">
                <div class="col-4 pe-1">
                    <div class="form-group">
                        <input type="number" class="form-control" name="lots[{{ $key }}][quantity]"
                            placeholder="Quantity" value="{{ $lot['quantity'] }}">
                        @if ($errors->has("lots.{$key}.quantity"))
                            <div class="invalid-feedback d-block">
                                {{ $errors->first("lots.{$key}.quantity") }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-4 ps-1 pe-1">
                    <div class="form-group">
                        <input type="date" class="form-control" name="lots[{{ $key }}][expiry_date]"
                            placeholder="Expiry Date" value="{{ $lot['expiry_date'] }}">
                        @if ($errors->has("lots.{$key}.expiry_date"))
                            <div class="invalid-feedback d-block">
                                {{ $errors->first("lots.{$key}.expiry_date") }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-2 ps-1 pe-1">
                    <button type="button" class="btn btn-danger w-100 btn-delete">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
                <div class="col-2 ps-1">
                    <button type="button" class="btn btn-success w-100 btn-add">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>

@push('styles')
    <style>
        .btn-add:not(.lot:last-child .btn-add) {
            display: none;
        }
    </style>
@endpush

@push('scripts')
    <script>
        var lotIndex = {{ count(old('lots', $product->lots ?? [[]])) - 1 }};

        var lotHtml = (index) => `
            <div class="row mb-3 lot">
                <div class="col-4 pe-1">
                    <div class="form-group">
                        <input type="number" class="form-control" name="lots[${index}][quantity]" placeholder="Quantity">
                    </div>
                </div>
                <div class="col-4 ps-1 pe-1">
                    <div class="form-group">
                        <input type="date" class="form-control" name="lots[${index}][expiry_date]" placeholder="Expiry Date">
                    </div>
                </div>
                <div class="col-2 ps-1 pe-1">
                    <button type="button" class="btn btn-danger w-100 btn-delete">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
                <div class="col-2 ps-1">
                    <button type="button" class="btn btn-success w-100 btn-add">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>
            </div>
        `;

        function checkLotButtons() {
            if ($('.lot').length === 1) {
                $('.btn-delete').hide();
            } else {
                $('.btn-delete').show();
            }
        }

        $(document).ready(function() {
            checkLotButtons();
        });

        $(document).on('click', '.btn-add', function() {
            $('#lots').append(lotHtml(++lotIndex));

            checkLotButtons();
        });

        $(document).on('click', '.btn-delete', function() {
            $(this).closest('.lot').remove();

            checkLotButtons();
        });
    </script>
@endpush
