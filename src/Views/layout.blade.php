<!DOCTYPE html>
<html>
	<head>

		<link rel="stylesheet" type="text/css" href="{{ asset('mp/css/fontawesome-all.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('mp/css/bootstrap.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('mp/css/mailpeek.css') }}">
		<meta name="author" content="Mohammed Isma <https://github.com/MohammedIsma">
		<title>MailPeek</title>
	</head>
	<body>
		<div style="background-color:#eee; border-bottom:1px solid #ccc; font-weight:bold; padding:5px 0; position:absolute; text-align:center; text-transform:uppercase; top:0; width:100%;">{{ env('APP_NAME', "powered by MailPeek") }}</div>
		<div class="container mailbox" id="mpeekApp">
			<div class="row">
				<div class="col-md-3">
					<div class="logo">
						<span class="small">Laravel</span>
						MailPeek
					</div>
					<div class="mailbox-box mailbox-box-solid">
						
						<div class="mailbox-box-header">
							
							<h3 class="mailbox-box-title">Folders</h3>

						</div>

						<div class="mailbox-box-body">
							
							<ul class="vertical-list">
								
								<li class="active"><a href="#">
									<i class="fa fa-inbox"></i>
									Unread
									<span class="label label-primary pull-12 flip">@{{ UnreadCount }}</span>
								</a></li>

							</ul>

						</div>

					</div> <!-- End Box -->
					<div class="text-left">
						<a href="#" class="text-danger" v-on:click="emptyMailbox()"><i class="fa fa-trash"></i> Empty the mailbox</a>
						<hr />
					</div>

				</div>
				<!-- Sidebar -->

				<div class="col-md-9">
					
					<div class="mailbox-box mailbox-box-primary">
						
						<div class="mailbox-box-header">
							
							<h3 class="mailbox-box-title">@{{ Messages.length }} Messages</h3>

						</div>

						<div class="mailbox-box-body">
							
							<div class="table-responsive mailbox-messages">
							    <table class="table table-hover table-striped">
							    	<thead>
							    		<tr>
							    			<td>Sent To</td>
							    			<td>Subject</td>
							    			<td>Attachment</td>
							    			<td>Date</td>
							    		</tr>
							    	</thead>
							        <tbody>
							            <tr v-for="Message in Messages" v-bind:class="{ unread: Message.attributes.unread }">
							                <td class="mailbox-name">
							                    <a href="javascript::void(0);" v-on:click="openmessage(Message.id)">
							                        @{{ Message.to_primary.name }} <@{{ Message.to_primary.email }}>
							                        <div v-if="Message.to.length>1"> +@{{ Message.to.length - 1 }}
							                    </a>
							                </td>
							                <td class="mailbox-subject">
							                    @{{ Message.subject }}
							                </td>
							                <td class="mailbox-attachment">
							                	<div v-if="(Message.attachments.length>0)">
							                		<i class="fa fa-paperclip"></i> @{{Message.attachments.length}}
							                	</div>
							                </td>
							                <td class="mailbox-date">
							                    @{{ Message.datetime }}
							                </td>
							            </tr>
							        </tbody>
							    </table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="{{ asset('mp/js/jquery.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('mp/js/vue.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('mp/js/vue-resource@1.3.5') }}"></script>
		<script>var exports = {};</script>
		<script type="text/javascript" src="{{ asset('mp/js/mpeek.js') }}"></script>
	</body>
</html>