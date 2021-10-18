<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="CSS/style.css">
  <title>管理システム</title>
</head>
<body>
  <h1>管理システム</h1>
  <div class="contact-form">
    <form method="post" action="{{ url('/search') }}">
      @csrf
      <table>
        <tr>
          <th><label for="">お名前</label></th>
          <td><input type="text" name="fullname" value="{{ $fullname }}"></td>
        </tr>
        <tr>
          <th>登録日</th>
            <td><input type="date" name="form"></td>
            <td><input type="date" name="until"></td>
        </tr>

        <tr>
          <th>メールアドレス</th>
          <td><input type="email" value="{{$email}}"></td>
        </tr>

        <tr>
          <th>性別</th>
            <td>
              <label><input type="radio" name="gender" value="" checked>全て</label>
              <label><input type="radio" name="gender" value="{{ $gender }}" >男</label>
              <label><input type="radio" name="gender" value="{{ $gender }}">女</label>
            </td>
        </tr>
      </table>

      <button type="submit">検索</button>
      <a href="">リセット</a>
    </form>
    @if(!empty($items))
  </div>
  <div>
    {{-- <article> --}}
      {{-- <p>全{{ $articles -> total() }}件中@if($articles -> firstItem() != $articles -> lastItem() ) {{$articles -> firstItem()}}件目から{{$articles -> lastItem()}}件 @else {{$articles -> firstItem()}}件 @endif</p> --}}
      {{-- <p>{{$articles -> links() }}</p><!-- ページネーション --> --}}
    
{{-- </article> --}}
  {{ $items->appends(request()->query())->links(vendor.pagination.semantic-ui) }}
  <table>
    <tr>
    <th>ID</th>
    <th>お名前</th>
    <th>性別</th>
    <th>メールアドレス</th>
    <th>ご意見</th>
    </tr>
   @foreach ($items as $item)
    <tr>
    <td>{{$item['id']}}</td>
    <td>{{ $item['fullname'] }}</td>
    <td>
      @if ($item['gender'] == 1)
                  男性
      @else
                  女性
      @endif
    </td>
    <td>{{ $item['email'] }}</td>
    <td>{{ $item['opinion'] }}</td>

    <!--削除ボタン-->
      <td>
        <form action="{{ route('delete') }}" method="post">
          <input type="hidden" name="id" value="{{$item->id}}">
            @csrf
            <button class="button-delete">削除</button>
            </form>
      </td>
    </tr>
    @endforeach
  </table>

    </div>
  @else
        <p>データがみつかりません</p>
  @endif
</body>
</html>