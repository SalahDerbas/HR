<h4>Hi, This is {{ $data['name'] }}</h4>
<table>
    <tr>
        Email :
    <td style="border: 1px solid #000; width: auto;font-size:15px;padding: 10px;"> {{ $data['email'] }}.</td>
    </tr>
    <tr>
        Subject :
        <td style="border: 1px solid #000; width: auto;font-size:15px;padding: 10px;"> {{ $data['subject'] }}.</td>
    </tr>
    <tr>
        Message :
        <td style="border: 1px solid #000; width: auto;font-size:15px;padding: 10px;"> {{ $data['message'] }}.</td>
    </tr>
</table>
