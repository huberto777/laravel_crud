@auth
    @if($article->isCommented())
        <div class="col-md-12text text-danger">już dodałeś komentarz do tego artykułu</div>
    @else
        <div class="col-md-12">
            <div class="jumbotron bg-dark text-white"><h2>Dodaj komentarz</h2>
                <hr class="bg-warning">
                <form {{ $novalidate }} action="{{ route('addComment',[$article->id,'Article']) }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <label for="content" class="col-md-2 col-form-label text-lg-right">treść:</label>
                        <div class="col-md-10">
                            <textarea name="content" id="" cols="30" rows="10" class="form-control">{{ old('content') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="rating" class="col-md-2 col-form-label text-lg-right">ocena:</label>
                        <div class="col-md-10">
                            <select name="rating" id="rating" class="form-control">
                                @for($i=1;$i<=5;$i++)
                                    <option value="{{ $i }}">{{ $i  }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-10 offset-2">
                            <button type="submit" class="btn btn-block btn-outline-warning">dodaj komentarz</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
@else
    <div class="col-md-12><a href="{{ route('login') }}">zaloguj się aby dodać komentarz</a></div>
@endauth
