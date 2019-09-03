var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var request = require('request')
var mysql = require('mysql');
var http = require('http');
var kjtime = '';
var kjnum = '';//==1黑桃 ==4红桃 3.8    ==3梅花 ==2方块 4.0
var kjArr = [3.8, 4, 4, 3.8, 20];//开奖倍数
var BetArr = [];
var UpperLimit = [[], []];
var GameUrl = 'http://39.96.38.193/';
var RobArr = [0, 0, 0, 0, 0];
setInterval(function () {
    request.post({ url: GameUrl + 'index.php/index/Ajax/req_api', form: {} }, function (error, body) {
        if (!error) {
            // console.log("请求成功");
        }
    })
    request({
        url: GameUrl + 'index.php/index/Ajax/fanrecord',
        method: "POST",
        json: true,
        headers: {
            "content-type": "application/json",
        },
        // body: requestData
    }, function (error, response, body) {
        if (!error && response.statusCode == 200) {
            // console.log(body) // 请求成功的处理逻辑
            if (body.kjtime != kjtime) {
                kjtime = body.kjtime;
                console.log('开奖咯', body);
                if (body.kjnum != 'wang') {
                    kjnum = body.kjnum % 10;
                } else {
                    kjnum = 4;
                }
                console.log(kjnum);
                console.log('开奖结果计算');
                //计算开奖结果
                for (var i = 0; i < BetArr.length; i++) {
                    SetMysql(BetArr[i], '开奖计算', kjnum);
                }
                BetArr = [];
                RobArr = [0, 0, 0, 0, 0];
                io.sockets.emit('总下注', { BetArr: BetArr, RobArr: RobArr });




                request({
                    url: GameUrl + 'index.php/index/Ajax/roomset',
                    method: "POST",
                    json: true,
                    headers: {
                        "content-type": "application/json",
                    },
                    // body: requestData
                }, function (error, response, body) {
                    console.log(error, response.statusCode);
                    if (!error && response.statusCode == 200) {
                        console.log('==返回===', body);
                        UpperLimit[0] = [body.dazhong, body.dazhongwang, body.hei, body.fang, body.hua, body.hong, body.wang];
                        UpperLimit[1] = [body.chuantongfang, body.chuantongfangw, body.ctfanghei, body.ctfangfang, body.ctfanghua, body.ctfanghong, body.ctfangwang];
                        console.log(UpperLimit[0], UpperLimit[1]);
                    }
                });

            }
        }
    });
    for (var i = 0; i < 2; i++) {
        var ran = Math.floor(Math.random() * 5);
        if (ran == 4) {
            if (Math.random() > 0.6) return;
        }
        RobArr[ran] += Math.floor(Math.random() * 10) * 20;
        io.sockets.emit('总下注', { BetArr: BetArr, RobArr: RobArr });
    }
}, 1000);

//数据库配置
var options = {
    host: '127.0.0.1',
    user: 'root',
    password: '123456',
    database: 'game'
};

server.listen(10008, function () {
    console.log('listening on *:' + 10008 + '   ....');
});
app.get('/', function (req, res) {
    res.send('<h1>Welcome Realtime Server</h1>');
});
var onlineuser = [];
var socket = io.on('connection', function (socket) {
    // console.log('链接成功1111');
    socket.on('登录', function (data) {
        console.log(data);
        var ishas = false;
        data.sid = socket.id;
        for (var i = 0; i < onlineuser.length; i++) {
            if (data.id == onlineuser[i].id) {
                onlineuser[i].sid = socket.id;
                ishas = true;
            }
        }
        if (!ishas) {
            onlineuser.push(data);
        }
        io.sockets.emit('登录', onlineuser);
        io.sockets.emit('总下注', { BetArr: BetArr, RobArr: RobArr });
    });
    socket.on('下注', function (data) {
        console.log('下注', data);
        var roomid = data.roomid;
        //判断当前桌有没有达到总下注的上限
        var zhuozong = 0;//当前下注的总金额
        for (var i = 0; i < BetArr.length; i++) {
            zhuozong += BetArr[i].zjine[roomid][data.index];
        }
        if (roomid == 0) {
            console.log(UpperLimit[0], UpperLimit[1]);
            if (data.index < 4) {
                //如果本桌是黑红梅方 大于下注限制
                if (zhuozong + data.fama > UpperLimit[0][0]) {
                    socket.emit('下注失败', '下注金额超过下注限制，下注失败');
                    return;
                }
            } else {
                if (zhuozong + data.fama > UpperLimit[0][1]) {
                    socket.emit('下注失败', '下注金额超过下注限制，下注失败');
                    return;
                }
            }
        } else {
            if (data.index < 4) {
                //如果本桌是黑红梅方 大于下注限制
                if (zhuozong + data.fama > UpperLimit[1][0]) {
                    socket.emit('下注失败', '下注金额超过下注限制，下注失败');
                    return;
                }
            } else {
                if (zhuozong + data.fama > UpperLimit[1][1]) {
                    socket.emit('下注失败', '下注金额超过下注限制，下注失败');
                    return;
                }
            }
        }

        var zong = data.xiazhuqian;//自己下注前的总金额
        var xiazhuzong = 0;//已经下注的总金额
        var benzhuozong = 0;//本桌下注的总金额
        for (var i = 0; i < BetArr.length; i++) {
            if (data.id == BetArr[i].id) {
                zong = BetArr[i].xiazhuqian;
                benzhuozong = BetArr[i].zjine[roomid][data.index];
                for (var j = 0; j < BetArr[i].zjine[roomid].length; j++) {
                    xiazhuzong += BetArr[i].zjine[roomid][j];

                }
            }
        }
        if (roomid == 0) {
            if (benzhuozong + data.fama > UpperLimit[0][data.index + 2]) {
                socket.emit('下注失败', '下注金额超过下注限制，下注失败');
                return;
            }
        } else {
            if (benzhuozong + data.fama > UpperLimit[1][data.index + 2]) {
                socket.emit('下注失败', '下注金额超过下注限制，下注失败');
                return;
            }
        }
        console.log(xiazhuzong + data.fama, '-------------------------', zong);
        if (xiazhuzong + data.fama > zong) return;
        var ishas = false;
        for (var i = 0; i < BetArr.length; i++) {
            if (data.id == BetArr[i].id) {
                // if (data.xiazhuqian)
                if (data.index != 4) {
                    if (BetArr[i].zjine[roomid][data.index] + data.fama > 9990) {
                        data.fama = 9990 - BetArr[i].zjine[roomid][data.index];
                        BetArr[i].zjine[roomid][data.index] = 9990;
                    } else {
                        BetArr[i].zjine[roomid][data.index] += data.fama;
                    }
                } else {
                    if (BetArr[i].zjine[roomid][data.index] + data.fama > 500) {
                        data.fama = 500 - BetArr[i].zjine[roomid][data.index];
                        BetArr[i].zjine[roomid][data.index] = 500;
                    } else {
                        BetArr[i].zjine[roomid][data.index] += data.fama;
                    }
                }
                ishas = true;
                socket.emit('下注成功', BetArr[i]);
            }
        }
        if (!ishas) {
            data.zjine = [[0, 0, 0, 0, 0], [0, 0, 0, 0, 0], [0, 0, 0, 0, 0]];
            data.zjine[roomid][data.index] = data.fama;
            BetArr.push(data);
            socket.emit('下注成功', data);
        }
        io.sockets.emit('总下注', { BetArr: BetArr, RobArr: RobArr });
        console.log(data.xiazhuqian - data.fama);
        socket.emit('xiazhu', (data.xiazhuqian - data.fama));
        SetMysql(data, '下注');
    })
    socket.on('撤销下注', function (data) {
        console.log(data);
        for (var i = 0; i < BetArr.length; i++) {
            if (data.id == BetArr[i].id) {
                SetMysql(BetArr[i], '撤销下注', 0, data.roomid);
                BetArr[i].zjine[data.roomid] = [0, 0, 0, 0, 0];
                // BetArr.splice(i, 1);
            }
        }
    });
    socket.on('disconnect', function () {
        for (var i = 0; i < onlineuser.length; i++) {
            if (socket.id == onlineuser[i].sid) {
                onlineuser.splice(i, 1);
            }
        }
    });
});
function SetMysql(data, type, kjnum, roomid) {
    var conn = mysql.createConnection(options);
    var ntime = Date.parse(new Date()) / 1000;
    if (type == '下注') {
        var sql_cou = "update tp_user_list set balance=balance-" + data.fama + " where id=" + data.id;
        console.log(sql_cou);
        conn.query(sql_cou, function (ers, res) {
            console.log("-----修改下注金币------");
            // socket.emit('下注成功', data);
            // io.sockets.emit('总下注', { BetArr: BetArr, RobArr: RobArr });
        });
    }
    if (type == '开奖计算') {
        for (var r = 0; r < 3; r++) {
            var zong = 0;
            for (var i = 0; i < 5; i++) {
                zong += data.zjine[r][i];
            }
            if (zong != 0) {
                //不是开大小王
                if (kjnum != 4) {
                    console.log('------开奖计算----', kjnum);
                    console.log(data);
                    console.log('------开奖计算-----');
                    var num = 0;
                    var num = data.zjine[r][kjnum] * kjArr[kjnum];
                } else {
                    var num = 0;
                    for (var i = 0; i < 4; i++) {
                        num += data.zjine[r][i];
                    }
                    num += kjArr[4] * data.zjine[r][4];
                }

                var sql_cou = "update tp_user_list set balance=balance+" + num + " where id=" + data.id;
                console.log(sql_cou);
                conn.query(sql_cou, function (ers, res) {
                    console.log("-----修改下注金币------");
                });
                //添加下注纪录
                var sql_xh = "INSERT INTO `tp_xiazhujilu` (`userid`,`hei`,`fangpian`,`meihua`,`hong`,`wang`,`kjnum`,`zengjia`,`time`,`shangfenqian`,`shangfenhou`,`roomid`) VALUES ('" +
                    data.id + "','" + data.zjine[[r]][0] + "','" + data.zjine[[r]][1] + "','" + data.zjine[[r]][2] + "','"
                    + data.zjine[[r]][3] + "','" + data.zjine[[r]][4] + "','" + kjnum + "','" + num + "','" + kjtime + "','" + data.xiazhuqian + "','" + (data.xiazhuqian - zong + num) + "','" + r + "')";
                conn.query(sql_xh, function (ers, res) {
                    console.log(sql_xh);
                    console.log("添加消耗记录表");
                });
            }
        }
    }
    if (type == '撤销下注') {
        var zong = 0;
        for (var i = 0; i < 5; i++) {
            zong += data.zjine[roomid][i];
        }
        var sql_cou = "update tp_user_list set balance=balance+" + zong + " where id=" + data.id;
        console.log(sql_cou);
        conn.query(sql_cou, function (ers, res) {
            console.log("-----修改下注金币------");
            socket.emit('撤销下注成功', data);
            io.sockets.emit('总下注', { BetArr: BetArr, RobArr: RobArr });
        });
    }

    if (type == '添加聊天记录') {
        var sql_xh = "INSERT INTO `tp_chat_record` (`userid`,`chatrecord`,`cid`,`time`,`nickname`,`headimgurl`,`imgurl`) VALUES ('" +
            data.id + "','" + data.text + "','" + data.recordId + "','" + ntime + "','" + data.name + "','" + data.icon + "','" + data.imgurl + "')";
        conn.query(sql_xh, function (ers, res) {
            console.log("添加聊天记录", sql_xh);
        });
    }
    //断开连接
    conn.end()
}