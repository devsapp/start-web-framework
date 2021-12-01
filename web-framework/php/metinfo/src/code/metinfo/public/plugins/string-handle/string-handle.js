/**
 * 模拟PHP sprintf 的函数
 * @returns string
 */
function str_repeat(i, m) {
    for (var o = []; m > 0; o[--m] = i);
    return o.join('');
}
function sprintf() {
    var i = 0, a, f = arguments[i++], o = [], m, p, c, x, s = '';
    while (f) {
        if (m = /^[^\x25]+/.exec(f)) {
            o.push(m[0]);
        }
        else if (m = /^\x25{2}/.exec(f)) {
            o.push('%');
        }
        else if (m = /^\x25(?:(\d+)\$)?(\+)?(0|'[^$])?(-)?(\d+)?(?:\.(\d+))?([b-fosuxX])/.exec(f)) {
            if (((a = arguments[m[1] || i++]) == null) || (a == undefined)) {
                throw('Too few arguments.');
            }
            if (/[^s]/.test(m[7]) && (typeof(a) != 'number')) {
                throw('Expecting number but found ' + typeof(a));
            }
            switch (m[7]) {
                case 'b': a = a.toString(2); break;
                case 'c': a = String.fromCharCode(a); break;
                case 'd': a = parseInt(a); break;
                case 'e': a = m[6] ? a.toExponential(m[6]) : a.toExponential(); break;
                case 'f': a = m[6] ? parseFloat(a).toFixed(m[6]) : parseFloat(a); break;
                case 'o': a = a.toString(8); break;
                case 's': a = ((a = String(a)) && m[6] ? a.substring(0, m[6]) : a); break;
                case 'u': a = Math.abs(a); break;
                case 'x': a = a.toString(16); break;
                case 'X': a = a.toString(16).toUpperCase(); break;
            }
            a = (/[def]/.test(m[7]) && m[2] && a >= 0 ? '+'+ a : a);
            c = m[3] ? m[3] == '0' ? '0' : m[3].charAt(1) : ' ';
            x = m[5] - String(a).length - s.length;
            p = m[5] ? str_repeat(c, x) : '';
            o.push(s + (m[4] ? a + p : p + a));
        }
        else {
            throw('Huh ?!');
        }
        f = f.substring(m[0].length);
    }
    return o.join('');
}
function range(start,end){
    var arr = [];
    for(var i = start;i < end;i++){
      arr.push(i);
    }
    return arr;
}

/**
 *
 * @param string 加密字符
 * @param operation 1：加密|0：解密
 * @param key 密钥
 * @param expiry 有效期
 * @param time
 * @param microtime
 * @returns {*}
 */
function authcode(string, operation, key, expiry,time,microtime) {
    operation = operation || 0;
    key = key || '';
    expiry = expiry || 0;
    var ckey_length = 4;
    key = md5(key ? key : '');
    var keya = md5(key.substr(0, 16));
    var keyb = md5(key.substr(16, 16));
    var keyc = ckey_length ? (operation ? md5(microtime).substr(-ckey_length) : string.substr(0, ckey_length)) : '';
    var cryptkey = keya + md5(keya + keyc);
    var key_length = cryptkey.length;

    if (operation) {
        string = encodeURI(string);
        string = sprintf('%010d', expiry ? expiry + parseInt(time) : 0) + md5(string + keyb).substr(0, 16) + string;
    } else {
        string = atob(string.substr(ckey_length));
    }

    var string_length = string.length;
    var result = '';
    var box = range(0, 256);
    var rndkey = [];
    for (var i = 0; i <= 255; ++i) {
        rndkey[i] = (cryptkey[i % key_length]).charCodeAt(0);
    }
    for (var j = i = 0; i < 256; ++i) {
        j = (j + box[i] + rndkey[i]) % 256;
        var tmp = box[i];
        box[i] = box[j];
        box[j] = tmp;
    }

    for (var a = j = i = 0; i < string_length; ++i) {
        a = (a + 1) % 256;
        j = (j + box[a]) % 256;
        var tmp = box[a];
        box[a] = box[j];
        box[j] = tmp;
        result += String.fromCharCode(string[i].charCodeAt(0) ^ (box[(box[a] + box[j]) % 256]));
    }
    if (operation) {
        return keyc + btoa(result).replace(/=/g, '');
    } else {
        if (result && (result.substr(0, 10) == 0 || result.substr(0, 10) - parseInt(time) > 0) && result.substr(10, 16) == md5(result.substr(26) + keyb).substr(0, 16)) {
            return decodeURI(result.substr(26));
        } else {
            return '';
        }
    }
}