<!DOCTYPE html>
<html>
	<head>
		<meta name="author" content="Mohammed Isma <https://github.com/MohammedIsma">
		<title>Email : {{ $Message->getId() }}</title>
	</head>
	<body>
		<table border="0" width="100%">
			<tr valign="top">
				<td width="26%">
					<table border="0" style="border:1px solid #ccc;" width="100%">
						<tr>
							<th style="background-color:#ccc;font-size:13px;padding:7px;text-align:left;">From</th>
							<td style="background-color:#ececec;font-size:13px;padding:5px">{{ $Message->getFrom() }}</td>
						</tr>
						<tr>
							<th style="background-color:#ccc;font-size:13px;padding:7px;text-align:left;">Subject</th>
							<td style="background-color:#ececec;font-size:13px;padding:5px">{{ $Message->getSubject() }}</td>
						</tr>
						<tr valign="top">
							<th style="background-color:#ccc;font-size:13px;padding:7px;text-align:left;">To</th>
							<td style="background-color:#ececec;font-size:13px;padding:5px">
								@foreach($Message->getTo() as $To)
									<div>{{ $To['name'] }} ({{ $To['email'] }})</div>
								@endforeach
							</td>
						</tr>
						<tr valign="top">
							<th style="background-color:#ccc;font-size:13px;padding:7px;text-align:left;">cc</th>
							<td style="background-color:#ececec;font-size:13px;padding:5px">
								@foreach($Message->getCC() as $cc)
									<div>{{ $cc['name'] }} ({{ $cc['email'] }})</div>
								@endforeach
							</td>
						</tr>
						<tr valign="top">
							<th style="background-color:#ccc;font-size:13px;padding:7px;text-align:left;">bcc</th>
							<td style="background-color:#ececec;font-size:13px;padding:5px">
								@foreach($Message->getBCC() as $bcc)
									<div>{{ $bcc['name'] }} ({{ $bcc['email'] }})</div>
								@endforeach
							</td>
						</tr>
						<tr valign="top">
							<th style="background-color:#ccc;font-size:13px;padding:7px;text-align:left;">Attachments</th>
							<td style="background-color:#ececec;font-size:13px;padding:5px">
								<ol style="margin:0;padding:0 0 0 10px;">
									@foreach($Message->getAttachments() as $attachment)
									<li><a href="/mailpeek/getfile/{{$Message->getId()}}/{{ $attachment['name'] }}">{{ $attachment['name'] }}</a></li>
									@endforeach
								</ol>
							</td>
						</tr>
					</table>
				</td>
				<td width="1%"></td>
				<td style="background-color:#fff;">
					<div style="">
						{!! $Message->getBody() !!}
					</div>
				</td>
			</tr>
		</table>
	</body>
</html>