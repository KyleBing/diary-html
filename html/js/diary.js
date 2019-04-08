
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

const categories = ['life','study','work','sport','bigevent','other'];
const cookie = {
    email: 'diaryEmail',
    token: 'diaryToken',
    username: 'diaryUsername',
    uid: 'diaryUid',
    category: 'diaryCategories',
    options: {expires: 7, path: '/'}
};



// 设置cookie
function setAuthorization(email, token, username, uid) {
    $.cookie(cookie.email,email,cookie.options);
    $.cookie(cookie.token,token,cookie.options);
    $.cookie(cookie.username,username,cookie.options);
    $.cookie(cookie.uid,uid,cookie.options);
}

// 获取cookie
function getAuthorization() {
    let email = $.cookie(cookie.email);
    let token = $.cookie(cookie.token);
    let username = $.cookie(cookie.username);
    let uid = $.cookie(cookie.uid);
    if (email === undefined || token === undefined){
        location = FrontURL.login;
        return false;
    } else {
        return {
            email: email,
            token: token,
            username: username,
            uid: uid
        }
    }
}

// 删除cookie
function deleteAuthorization() {
    $.removeCookie(cookie.email,{path: '/'});
    $.removeCookie(cookie.token,{path: '/'});
    $.removeCookie(cookie.username,{path: '/'});
    $.removeCookie(cookie.uid,{path: '/'});
}

// Prompt 提示
function prompt(title, callback = ()=>{}, timeout = 1.5){
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


