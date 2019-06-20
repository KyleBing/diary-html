
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
    index:  'index.html',
    edit:   'edit.html'
};

const categories = ['life','study','work','sport','game','film','bigevent','other'];
const COOKIE = {
    email: 'diaryEmail',
    token: 'diaryToken',
    username: 'diaryUsername',
    uid: 'diaryUid',
    category: 'diaryCategories',
    keyword: 'keyword',
    options: {expires: 7, path: '/'}
};


// 设置cookie
function setAuthorization(email, token, username, uid) {
    $.cookie(COOKIE.email,email,COOKIE.options);
    $.cookie(COOKIE.token,token,COOKIE.options);
    $.cookie(COOKIE.username,username,COOKIE.options);
    $.cookie(COOKIE.uid,uid,COOKIE.options);
}

// 获取cookie
function getAuthorization() {
    let email = $.cookie(COOKIE.email);
    let token = $.cookie(COOKIE.token);
    let username = $.cookie(COOKIE.username);
    let uid = $.cookie(COOKIE.uid);
    if (email === undefined || token === undefined){
        if (location.pathname.indexOf('login.html') < 0){
            location = FrontURL.login;
        }
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
    $.removeCookie(COOKIE.email,{path: '/'});
    $.removeCookie(COOKIE.token,{path: '/'});
    $.removeCookie(COOKIE.username,{path: '/'});
    $.removeCookie(COOKIE.uid,{path: '/'});
}


const PopMessageType = {
    success:    "success",
    warning:    "warning",
    danger:     "danger",
    default:    "default"
};

// Prompt 提示
function popMessage(type, title, callback = ()=>{}, timeout = 1.5){
    var popClass = 'popMessage-'+type;
    let template = ` <div class="popMessage ${popClass}">
                        <h3>${title}</h3>
                    </div>`;
    $('body').append(template);

    setTimeout(() => {
        $('.popMessage').remove();
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

const WEEKDAY = {
    0: '周日',
    1: '周一',
    2: '周二',
    3: '周三',
    4: '周四',
    5: '周五',
    6: '周六',
};

