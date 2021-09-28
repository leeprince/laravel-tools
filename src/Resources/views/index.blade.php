<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <link rel="stylesheet" href="{{$assetPath}}/bootstrap-3.3.7-dist/css/bootstrap.min.css">
</head>
<body>
<fieldset>
    <legend>单元测试窗口</legend>
    <form id="unitForm">
        {{--@csrf--}}

        {{--关于csrf安全防护：laravel 低于等于 5.5 版本使用--}}
        {{-- csrf_field() --}}
        <table>
            <tr>
                <td>命名空间(命名空间可以包含类名，然后下面的类名可以省略)</td>
                <td><input type="text" name="namespace" value="{{old('namespace')??""}}"></td>
            </tr>
            <tr>
                <td>类名</td>
                <td><input type="text" name="className" value="{{old('className')??""}}"></td>
            </tr>
            <tr>
                <td>测试方法名</td>
                <td><input type="text" name="action" value="{{old('action')??""}}"></td>
            </tr>
            <tr>
                <td>传递参数以英文 | 分割</td>
                <td><input type="text" name="param" value="{{old('param')??""}}"></td>
            </tr>
            <tr>
            </tr>
        </table>
    </form>
</fieldset>
<td colspan="2"><button onclick="startUnitTest()">开始测试</button></td>

</body>
</html>

<style>
    input {
        width: 100%;
    }
    input[type=submit] {
        margin-top: 50px;
        box-sizing: content-box;
        -moz-box-sizing: content-box;
        -webkit-box-sizing: content-box;
        background-color: #9bd1de;
        border-radius: 5px;
    }
    table>tbody>tr>td:nth-of-type(2) {
        width:50%;
    }
</style>
<script src="{{$assetPath}}/jquery-3.5.1/jquery-3.5.1.min.js"></script>
<script src="{{$assetPath}}/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
<script type="text/javascript">
    function startUnitTest() {
        var formData = $('#unitForm').serialize()
        pajax("{{route('unit.request')}}", formData, function (res) {
            console.log(res)
            $('#unitResult').text(res)
        })
    }

    function pajax(url, data, succCallback, type = 'post', dataType = 'json') {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            data: data,
            type: type,
            dataType: dataType,
            success: succCallback,
            error: function () {
                console.log('执行失败')
                // alert('执行失败')
            }
        })
    }
</script>