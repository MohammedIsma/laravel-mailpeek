Vue.http.interceptors.push(function(request, next){
    request.method = "POST";
    request.headers.set('X-CSRF-TOKEN', $("meta[name='csrf-token']").attr("content"));
    next();
});

$(function(){
    function initData(){
        return {
                    Messages: {},
                    UnreadCount : "0",
                };
    }
    var my_dash = new Vue ( {
        el: '#mpeekApp',
        data: function(){
            return initData();
        },
        computed: {
        },
        methods: {
            loadData: function () {
                $.get('/mailpeek/get_mbox', function (response) {
                    response = JSON.parse(response);
                    this.Messages = response.messages;
                    this.UnreadCount = response.meta.unread_count;
                }.bind(this));
            },
            openmessage: function(messageID){
                var strWindowFeatures = "menubar=no,location=no,resizable=yes,scrollbars=yes,status=no";
                window.open("/mailpeek/message/"+messageID, "_blank", strWindowFeatures);
            },
            emptyMailbox: function(){
                $.get('/mailpeek/doempty', function (response) {}.bind(this));
                Object.assign(this.$data, initData());
            }
        },
        mounted: function () {
            this.loadData();

            setInterval(function () {
                this.loadData();
            }.bind(this), 5000); 
        }
    });
});