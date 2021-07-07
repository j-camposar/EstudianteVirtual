//Objeto usuario
function userData(name, rut, email, phone, company, gerency){
    this.name = name,
    this.rut = rut,
    this.email = email,
    this.phone = phone,
    this.company = company,
    this.gerency = gerency
}
//Función para subir los datos al sistema.
function login(name, rut, email, phone, company, gerency){
    var rutFilter = rut.replace("-","").replace(".","");
    var user = new userData(name, rut, email, phone,company,gerency);
    localStorage.setItem("currentUser", JSON.stringify(user));
    saveUsersData(user);
}
function getUsersData(){
    let usersData = [];
    usersData = JSON.parse(localStorage.getItem("userData"));
    return usersData;
}
function saveUsersData(userData){
    let usersData = [];
    if(getUsersData()!=null){
        usersData = getUsersData();
        usersData.push(userData);
        localStorage.setItem("userData",JSON.stringify(usersData));
    }else{
        usersData.push(userData);
        localStorage.setItem("userData",JSON.stringify(usersData));
    }
}

function getCurrentUser(){
    let user = JSON.parse(localStorage.getItem("currentUser"));
    return user;
}

function testDataMgm(){
    let temp = getUsersData();
    temp.forEach(element => {
        console.log(element);
    });
}

function loadGData(){
    //Answer Settings for G21 Data
    var ansSettings = {
        "async": true,
        "crossDomain": true,
        "url": "http://35.199.124.107/prueba/preguntas.php?t=ans",
        "method": "GET",
        "headers": {
            "User-Agent": "TabletExplor",
            "Accept": "*/*",
            "Cache-Control": "no-cache",
            "Host": "35.199.124.107",
            "accept-encoding": "gzip, deflate",
            "Connection": "keep-alive",
            "cache-control": "no-cache"
        }
    }
    //Option Settings for G21 Data
    var optSettings = {
        "async": true,
        "crossDomain": true,
        "url": "http://35.199.124.107/prueba/preguntas.php?t=opt",
        "method": "GET",
        "headers": {
            "User-Agent": "TabletExplor",
            "Accept": "*/*",
            "Cache-Control": "no-cache",
            "Host": "35.199.124.107",
            "accept-encoding": "gzip, deflate",
            "Connection": "keep-alive",
            "cache-control": "no-cache"
        }
    }

    //Just last date of data upload (G21)
    var dteSettings = {
        "async": true,
        "crossDomain": true,
        "url": "http://35.199.124.107/prueba/preguntas.php?t=dte",
        "method": "GET",
        "headers": {
            "User-Agent": "TabletExplor",
            "Accept": "*/*",
            "Cache-Control": "no-cache",
            "Host": "35.199.124.107",
            "accept-encoding": "gzip, deflate",
            "Connection": "keep-alive",
            "cache-control": "no-cache"
        }
    }

    $.ajax(ansSettings).done(function (response) {
        localStorage["G21Q"] = JSON.stringify(JSON.parse(response));
        document.getElementById("ok1").innerHTML = "o";
    }).fail(function(error){
        alert(JSON.stringify(error));
    });

    $.ajax(optSettings).done(function (response) {
        localStorage["G21A"] = JSON.stringify(JSON.parse(response));
        document.getElementById("ok2").innerHTML = "o";
    }).fail(function(error){
        alert(JSON.stringify(error));
    });

    $.ajax(dteSettings).done(function (response) {
        localStorage["GUP"] = response;
        document.getElementById("ok3").innerHTML = "o";
    }).fail(function(error){
        alert(JSON.stringify(error));
    });



}