<!DOCTYPE html>
<html>
<head>
    <title>Education Technology</title>
</head>
<body>
    <h1>Dear Admin,</h1>
    <p>Someone has contacted you following is their information:</p>
    <p>Name: {{ $data['name'] }}<br>
    <b>Email:</b> {{ $data['email'] }}<br>
    <b>Subject:</b> {{ $data['subject'] }}<br>
    <b>Province:</b> {{ getProvinceName($data['province_id']) }}<br>
    <b>District:</b> {{ getDistrictName($data['district_id']) }}<br>
    <b>Message:</b><br> {{ $data['message'] }}<br>
    </p>
    
</body>
</html>