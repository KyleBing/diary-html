
$(function () {
    // INIT
    setMenuHeight();


    // RESIZE
    $(window).resize(function () {
        setMenuHeight();
    });

    function setMenuHeight() {
        $('.menu-panel').css({
            height: window.innerHeight
        });
    }
});

let URL = {
    userOperation:  '../portal/userOperation.php',
    diaryOperation: '../portal/diaryOperation.php'
};

let FrontURL = {
    login:  'login.html',
    index:  'index.html'
};


let cookieEmailName = 'diaryEmail';
let cookieTokenName = 'diaryToken';

// 设置cookie
function setAuthorization(email, token) {
    $.cookie(cookieEmailName,email,{expires: 7, path: '/'});
    $.cookie(cookieTokenName,token,{expires: 7, path: '/'});
}

// 获取cookie
function getAuthorization() {
    let email = $.cookie(cookieEmailName);
    let token = $.cookie(cookieTokenName);
    if (email === undefined || token === undefined){
        prompt('请先登录',()=>{location = FrontURL.login});
        return false;
    } else {
        return {
            email: email,
            token: token
        }
    }
}

// 删除cookie
function deleteAuthorization() {
    $.removeCookie(cookieEmailName,{path: '/'});
    $.removeCookie(cookieTokenName,{path: '/'});
}


function prompt(title, callback = ()=>{}, timeout = 3){
    let template = ` <div class="prompt">
                        <h3>${title}</h3>
                    </div>`;
    $('body').append(template);

    setTimeout(() => {
        $('.prompt').remove();
        callback();
    },1000 * timeout);
}


let API = {
    getData: (url, queryData, onSuccess, onError, onComplate) => {
        let authorizationKey = getAuthorization();
        if (authorizationKey){
            $.ajax({
                url: url,
                dataType: 'json',
                method: 'GET',
                success:(data) => {
                    onSuccess && onSuccess(data)
                },
                error: (xhr) => {
                    console.log(xhr);
                    onError && onError(data)
                },
                onComplate: (xhr) => {
                    onComplate && onComplate(xhr)
                }
            })
        } else {
            location = FrontURL.login;
        }
    },

    setData: (url, queryData, onSuccess, onError, onComplate) => {
        let authorizationKey = getAuthorization();
        if (authorizationKey){
            $.ajax({
                url: url,
                dataType: 'json',
                method: 'POST',
                success:(data) => {
                    onSuccess && onSuccess(data)
                },
                error: (xhr) => {
                    console.log(xhr);
                    onError && onError(data)
                },
                onComplate: (xhr) => {
                    onComplate && onComplate(xhr)
                }
            })
        } else {
            location = FrontURL.login;
        }
    }
};
