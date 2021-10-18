<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/confirm.css">
  <title>内容確認</title>
</head>
<body>
  <h1>内容確認</h1>
  <div class="contact-form">
    <form method="post" action="process">
      @csrf
      <div class="box_con">
      <table class="formTable">
        <tr>
          <th>お名前</th>
          @if(isset($inputs['lastname']))
          <td>{{ $inputs['lastname'] }}{{$inputs['firstname']}}</td>
          @endif
        </tr>


        <tr>
          <th>性別</th>
            <td>
              @if ($inputs['gender'] == 1)
                  男性
              @else
                  女性
              @endif
            </td>
        </tr>

        <tr>
          <th>メールアドレス</th>
          <td>{{$inputs['email']}}</td>
        </tr>

        <tr>
          <th><label>郵便番号</label></th>
          <td>〒{{ $inputs['zip11'] }}</td>
          <input type="hidden" name="zip11" value="{{ $inputs['zip11'] }}">
        </tr>

        <tr>
          <th><label>住所</label></th>
          <td>{{ $inputs['addr11'] }}</td>
          <input type="hidden" name="addr11" value="{{ $inputs['addr11'] }}">
        </tr>

        <tr>
          <th><label>建物名</label></th>
          <td>{{$inputs['building_name']}}</td>
          <input type="hidden" name="building_name" value="{{ $inputs['building_name'] }}">
        </tr>

        <tr>
          <th>ご意見</th>
          <td>{{$inputs['opinion']}}</td>
        </tr>
      </table>
      <div class="center-block">
        <button name="action" type="submit" value="submit">送信</button>
        <a href="{{ route('return') }}">修正する</a>
      </div>
    </form>
  </div>
</body>
</html>