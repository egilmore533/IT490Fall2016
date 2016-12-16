function hideLogin() {
    document.getElementById("logincontainer").style.display = "none";
}

function hideCL() {
    document.getElementById("clcontainer").style.display = "none";
}
function hideJL() {
    document.getElementById("jlcontainer").style.display = "none";
}

function openNav() {
    document.getElementById("sidenav").style.width = "250px";
}

function closeNav() {
    document.getElementById("sidenav").style.width = "0";
}

var loginOverlay = {
    show: function() {
        
        var color = 'black'; // SET THE COLOR HERE (IT CAN BE A HEX COLOR e.g. #FF00FF)
        var opacity = 0.7; // SET AN OPACITY HERE - MUST BE BETWEEN 0 AND 1

        var o = document.getElementById('doc_overlay');
        if(!o) {
            var o = document.createElement('div');
            o.id = "doc_overlay";
            loginOverlay.style(o,{
                position: 'absolute',
                top: 0,
                left: 0,
                width: '100%',
                height: loginOverlay.getDocHeight()+'px',
                background: color,
                zIndex: 1000,
                opacity: opacity,
                filter: 'alpha(opacity='+opacity*100+')'
            });
            document.getElementById('body').appendChild(o);
            o.onclick = function() {loginOverlay.hide(); hideLogin();};
        } else {
            loginOverlay.style(o,{background:color||'#000',display:'block'});
        }
        document.getElementById("logincontainer").style.display = "block";
    },
    hide: function() {
        var o = document.getElementById('doc_overlay');
        o.style.display = 'none';
    },
    style: function(obj,s) {
        for ( var i in s ) {
            obj.style[i] = s[i];
        }
    },
    getDocHeight: function() {
        var Y,YT;
        if( self.innerHeight ) {Y = self.innerHeight;}
        else if (document.documentElement && document.documentElement.clientHeight) {Y = document.documentElement.clientHeight;} 
        if( document.body ) {YT = document.body.clientHeight;}
        if(YT>Y) {Y = YT;}
        return Y;
    }
}
var clMusic = new Audio('../sound/title.mp3');
var createLeagueOverlay = {
    
    show: function() {
        
        var color = 'black'; // SET THE COLOR HERE (IT CAN BE A HEX COLOR e.g. #FF00FF)
        var opacity = 0.7; // SET AN OPACITY HERE - MUST BE BETWEEN 0 AND 1

        var o = document.getElementById('doc_overlay');
        if(!o) {
            var o = document.createElement('div');
            o.id = "doc_overlay";
            createLeagueOverlay.style(o,{
                position: 'absolute',
                top: 0,
                left: 0,
                width: '100%',
                height: createLeagueOverlay.getDocHeight()+'px',
                background: color,
                zIndex: 1000,
                opacity: opacity,
                filter: 'alpha(opacity='+opacity*100+')'
            });
            document.getElementById('body').appendChild(o);
            o.onclick = function() {createLeagueOverlay.hide(); hideCL();};
        } else {
            createLeagueOverlay.style(o,{background:color||'#000',display:'block'});
        }
        document.getElementById("clcontainer").style.display = "block";
        clMusic.play();
    },
    hide: function() {
        var o = document.getElementById('doc_overlay');
        o.style.display = 'none';
        clMusic.pause();
        clMusic.currentTime = 0;
    },
    style: function(obj,s) {
        for ( var i in s ) {
            obj.style[i] = s[i];
        }
    },
    getDocHeight: function() {
        var Y,YT;
        if( self.innerHeight ) {Y = self.innerHeight;}
        else if (document.documentElement && document.documentElement.clientHeight) {Y = document.documentElement.clientHeight;} 
        if( document.body ) {YT = document.body.clientHeight;}
        if(YT>Y) {Y = YT;}
        return Y;
    }
}
var leagueid;
var lid;
var joinLeagueOverlay = {
    
    
    show: function(leagueid) {
        
        var color = 'black'; // SET THE COLOR HERE (IT CAN BE A HEX COLOR e.g. #FF00FF)
        var opacity = 0.7; // SET AN OPACITY HERE - MUST BE BETWEEN 0 AND 1
        lid = leagueid;
        var o = document.getElementById('doc_overlay');
        if(!o) {
            var o = document.createElement('div');
            o.id = "doc_overlay";
            createLeagueOverlay.style(o,{
                position: 'absolute',
                top: 0,
                left: 0,
                width: '100%',
                height: joinLeagueOverlay.getDocHeight()+'px',
                background: color,
                zIndex: 1000,
                opacity: opacity,
                filter: 'alpha(opacity='+opacity*100+')'
            });
            document.getElementById('body').appendChild(o);
            o.onclick = function() {joinLeagueOverlay.hide(); hideJL();};
        } else {
            joinLeagueOverlay.style(o,{background:color||'#000',display:'block'});
        }
        document.getElementById("jlcontainer").style.display = "block";
        document.getElementById("jlbutton").onclick = function() {joinLeagueOverlay.sendJLRequest();};
        clMusic.play();
    },
    hide: function() {
        var o = document.getElementById('doc_overlay');
        o.style.display = 'none';
        clMusic.pause();
        clMusic.currentTime = 0;
    },
    style: function(obj,s) {
        for ( var i in s ) {
            obj.style[i] = s[i];
        }
    },
    getDocHeight: function() {
        var Y,YT;
        if( self.innerHeight ) {Y = self.innerHeight;}
        else if (document.documentElement && document.documentElement.clientHeight) {Y = document.documentElement.clientHeight;} 
        if( document.body ) {YT = document.body.clientHeight;}
        if(YT>Y) {Y = YT;}
        return Y;
    },
        
    sendJLRequest: function() {
        request = new XMLHttpRequest();
        request.onreadystatechange = handleJLResponse;
        request.open("POST","rpc/rpc.php",true);
        request.setRequestHeader("Content-type","application/json");
        var data = JSON.stringify({request:"jl",lid:lid});
        request.send(data);
    },
    handleJLResponse: function() {
        window.top.location.href = "myaccount.php";
    }
}

var number;
var theleagueid;

var createTeamOverlay = {
    
    
    show: function(number, theleagueid) {
        
        var color = 'black'; // SET THE COLOR HERE (IT CAN BE A HEX COLOR e.g. #FF00FF)
        var opacity = 0.7; // SET AN OPACITY HERE - MUST BE BETWEEN 0 AND 1
        lid = leagueid;
        var o = document.getElementById('doc_overlay');
        if(!o) {
            var o = document.createElement('div');
            o.id = "doc_overlay";
            createLeagueOverlay.style(o,{
                position: 'absolute',
                top: 0,
                left: 0,
                width: '100%',
                height: createTeamOverlay.getDocHeight()+'px',
                background: color,
                zIndex: 1000,
                opacity: opacity,
                filter: 'alpha(opacity='+opacity*100+')'
            });
            document.getElementById('body').appendChild(o);
            o.onclick = function() {createTeamOverlay.hide(); hideJL();};
        } else {
            createTeamOverlay.style(o,{background:color||'#000',display:'block'});
        }
        document.getElementById("ctcontainer").style.display = "block";
        document.getElementById("ctbutton").onclick = function() {createTeamOverlay.sendCTRequest(number, theleagueid);};
        clMusic.play();
    },
    hide: function() {
        var o = document.getElementById('doc_overlay');
        o.style.display = 'none';
        clMusic.pause();
        clMusic.currentTime = 0;
    },
    style: function(obj,s) {
        for ( var i in s ) {
            obj.style[i] = s[i];
        }
    },
    getDocHeight: function() {
        var Y,YT;
        if( self.innerHeight ) {Y = self.innerHeight;}
        else if (document.documentElement && document.documentElement.clientHeight) {Y = document.documentElement.clientHeight;} 
        if( document.body ) {YT = document.body.clientHeight;}
        if(YT>Y) {Y = YT;}
        return Y;
    },
        
    sendCTRequest: function(number, lid)
    {
        var trainerid = document.getElementById("trnid").value;
        
        request = new XMLHttpRequest();
        request.onreadystatechange = createTeamOverlay.handleCTResponse;
        request.open("POST","rpc/rpc.php",true);
        request.setRequestHeader("Content-type","application/json");
        var data = JSON.stringify({request:"ct",number:number,trainerid:trainerid,lid:lid});
        request.send(data);
    },
    handleCTResponse: function()
    {
        window.top.location.reload(false); 
    },
}

var type;

function tdbRequest(type)
{
    
    if(type == "none")
    {
        var trainer = document.getElementById("searchbar").value;
    }
    else
    {
        var trainer = type;
    }
    request = new XMLHttpRequest();
    
    request.onreadystatechange = handleTDBResponse;
    request.open("POST","rpc/rpc.php",true);
    request.setRequestHeader("Content-type","application/json");
    var data = JSON.stringify({request:"tdb",trainer:trainer});
    request.send(data);

}
function handleTDBResponse()
{
    document.getElementById("tdb").innerHTML = request.responseText.substring(3, request.responseText.length - 1);      
}

    
function schedRequest()
{
    
    request = new XMLHttpRequest();
    request.onreadystatechange = handleSchedResponse;
    request.open("POST","rpc/rpc.php",true);
    request.setRequestHeader("Content-type","application/json");
    var data = JSON.stringify({request:"sched"});
    request.send(data);
}
function handleSchedResponse()
{ 
    document.getElementById("sched").innerHTML = request.responseText.substring(3, request.responseText.length - 1);
}
function sendBetRequest(event,reqType,fid,tid)
{
    if(reqType == 'show')
    {
        var d = document.getElementById("confirmpanel");
    
        d.style.position = "absolute";
        d.style.left = event.clientX+'px';
        d.style.top = event.clientY+'px';
        document.getElementById("confirmpanel").style.display = "block";
        document.getElementById("hm").style.display = "block";
        document.getElementById("confirm").style.display = "block";
        document.getElementById("confirm").onclick = function(){sendBetRequest(null,"placebet",fid,tid);};
    }
    else{
        var funds = document.getElementById("hm").value;
        
        request = new XMLHttpRequest();
        request.onreadystatechange = handleBetResponse;
        request.open("POST","rpc/rpc.php",true);
        request.setRequestHeader("Content-type","application/json");
        var data = JSON.stringify({request:"placebet",fid:fid,tid:tid,funds:funds});
        request.send(data);
    }
}
function handleBetResponse()
{
    document.getElementById("betbal").innerHTML = "Balance: $" + request.responseText;
    document.getElementById("confirmpanel").style.display = "none";
    document.getElementById("hm").style.display = "none";
    document.getElementById("confirm").style.display = "none";
}