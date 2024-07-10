var loadRealTimeUser;

const RealTime = {
    logoutUser: function(callback){
        loadRealTimeUser = setInterval((e)=>{
            $.ajax({
                type: "get",
                url: "/admin/realtime/logoutUser",
                data: {

                },
                success: function (response) {
                    if(response.change){
                        callback();
                    }
                }
            });
        }, 30000);
    },
    pauseRealTimeUser: function(){
        clearInterval(loadRealTimeUser);
    },
    handleEvent: function(){

    },
    start: function(listCallback){
        this.handleEvent();
        this.logoutUser(listCallback[0]);
    }
};

RealTime.start([
    function(){
        const listUser = document.getElementById('list_users');
        if(listUser){
            loadContacts();
        }
    },
]);