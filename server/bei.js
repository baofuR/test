var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var request = require('request')
var mysql = require('mysql');
var http = require('http');
var kjtime = 300;//开奖倒计时
var newQiHao = '';
var kjArr = [];//开奖号码
var body = '';//开奖信息
var shoushui = 0.02;
var iskaijiang = false;
var NextRecordArr = [[], [], []];
var yingZhuoArr = [[], [], []];
var NextKJArr = [[], [], []];
var GameUrl = 'http://www.star-trip.net.cn/';
var timeDJS = 60;  //开奖倒计时
var isblkj = false;//本轮是否开奖
// var newQiHao = '';//上期号码 
var CardArr = [];
var RoomArr = [
    { cArr: [[], [], []], cardArr: [], OnRoomArr: [], BetArr: [[], [], [], [], [], [], [], []], STATE: '' },
    { cArr: [[], [], []], cardArr: [], OnRoomArr: [], BetArr: [[], [], [], [], [], [], [], []], STATE: '' },
    { cArr: [[], [], []], cardArr: [], OnRoomArr: [], BetArr: [[], [], [], [], [], [], [], []], STATE: '' }
];
//cArr 每
var STATE = '';
onChouShui();
function onChouShui() {
    request({
        url: GameUrl + 'index.php/index/ajax/dcxchoushui',
        method: "POST",
        json: true,
        headers: {
            "content-type": "application/json",
        },
        // body: requestData
    }, function (error, response, body) {
        if (!error && response.statusCode == 200) {
//            console.log(body);
            shoushui = body.choushui / 100;
        }
    });
}


OpenPrize();
initOutCard();
setInterval(function () {
    if (timeDJS >= 42 && timeDJS <= 59) {
        OpenPrize();
    }
    timeDJS--;
    if (timeDJS <= 0) timeDJS = 60;
    if (timeDJS == 42) {
        for (var i = 0; i < 3; i++) {
            io.sockets.in(i).emit('结算', RoomArr[i]);
        }
    }
    if (timeDJS == 34) {
        STATE = '结束结算';
        for (var i = 0; i < 3; i++) {
            io.sockets.in(i).emit('结束结算', RoomArr[i]);
        }
    }
    if (timeDJS < 34) {
        if (isblkj) {
            initOutCard();
            onChouShui();//抽水计算
            STATE = '开始下注';
         //   for (var i = 0; i < 3; i++) {
          //      RoomArr[i].BetArr = [[], [], [], [], [], [], [], []];
           // }
            isblkj = false;
        }
    }
    if (timeDJS <= 3) {
        //下注结束   开始封盘
        STATE = '等待开奖';
        for (var i = 0; i < 3; i++) {
            io.sockets.in(i).emit('等待开奖', RoomArr[i]);
        }
    }

    for (var i = 0; i < 3; i++) {
        
        io.sockets.in(i).emit('房间信息', { RoomArr: RoomArr[i], STATE: STATE, kjtime: timeDJS, newQiHao: newQiHao, kjArr: kjArr });
    }

}, 1000);
//数据库配置
var options = {
    host: '127.0.0.1',
    user: 'root',
    password: '123456',
    database: 'game'
};
/**
 * 50秒发牌 
 * 开奖结算 
 * 
 * */


setInterval(function () {
    request({
        url: GameUrl + 'index.php/index/ajax/req_api',
        method: "POST",
        json: true,
        headers: {
            "content-type": "application/json",
        },
        // body: requestData
    }, function (error, response, body) {
        if (!error && response.statusCode == 200) {
//            console.log('====', body);
        }
    });
}, 3000);



function OpenPrize() {
    request({
        url: GameUrl + 'index.php/index/ajax/fanrecord',
        method: "POST",
        json: true,
        headers: {
            "content-type": "application/json",
        },
        // body: requestData
    }, function (error, response, body) {
        if (!error && response.statusCode == 200) {
            // console.log('开奖时间', body);
            timeDJS = 60 - body.time % 60;
            // 请求成功的处理逻辑
            if (newQiHao != body.kjtime) {
                console.log('开奖了', newQiHao, body);
                newQiHao = body.kjtime;
                var prizeNum = Math.floor(body.record / 10000);
                var b = body.record;
                var arr = [];
                for (var i = 0; i < body.record.length; i++) {
                    var a = b % 10;
                    arr.push(a);
                    b = (b - a) / 10;
                }
                for (var i = 0; i < 5; i++) {
                    kjArr[i] = arr[4 - i];
                }
                //开奖
                for (var i = 0; i < 3; i++) {
                    // console.log('===149===', RoomArr[i].cArr);
                    RoomArr[i].kjArr = kjArr;
                    STATE = '结算';
                    RoomArr[i].STATE = '结算';
                    for (var j = 0; j < 8; j++) {
                        var kj0 = kjArr[0];
                        var kj1 = kjArr[1];
                        var kj2 = kjArr[2];
                        if (kj0 == 9 || kj0 == 0) kj0 = 1;
                        if (kj1 == 9 || kj1 == 0) kj1 = 1;
                        if (kj2 == 9 || kj2 == 0) kj2 = 1;
                        var pos0 = Math.abs((9 - kj0 + j)) % 8;
                        var pos1 = Math.abs((9 - kj1 + j)) % 8;
                        var pos2 = Math.abs((9 - kj2 + j)) % 8;
                        // console.log(kj0, kj1, kj2, '===============', pos0, pos1, pos2);
                        RoomArr[i].cardArr.push({
                            id: j, card: [RoomArr[i].cArr[0][pos0],
                            RoomArr[i].cArr[1][pos1],
                            RoomArr[i].cArr[2][pos2]]
                        });
                        RoomArr[i].cardArr[j].sortid = j;
                    }
                    // console.log('===172===', RoomArr[i].cardArr);
                    io.sockets.in(i).emit('开奖', RoomArr[i]);
                }
                setTimeout(JieSuan, 4000);
                isblkj = true;
            }
        }
    });
}
//初始化 牌 
function initOutCard() {
    // console.log('==========发牌==========');
    // console.log('==========发牌==========');
    for (var m = 0; m < 3; m++) {
        var CardArr = [];
        var card = [];
        for (var i = 1; i < 14; i++) {
            card.push(i * 10 + 1, i * 10 + 2, i * 10 + 3, i * 10 + 4);
        }
        card.sort(function (a, b) { return Math.random() - 0.5; });
        RoomArr[m].cardArr = [];
        RoomArr[m].cArr = [[], [], []];
        for (var i = 0; i < 8; i++) {
            for (var j = 0; j < 3; j++) {
                RoomArr[m].cArr[j].push(card[0]);
                card.splice(0, 1);
            }

        }
        console.log(RoomArr[m].cArr);
        io.sockets.in(m).emit('发牌', RoomArr[m]);
    }
    // console.log(RoomArr);
}
var yingZhuo = [];//赢钱的桌
function JieSuan() {
    // console.log('==========结算==========');
    // console.log('==========结算==========');
    // console.log('==========结算==========');
    isblkj = true;
    yingZhuo = [];
    NextRecordArr = [[], [], []];
    for (var r = 0; r < 3; r++) {
        RoomArr[r].SortCard = [];
        for (var i = 0; i < RoomArr[r].cardArr.length; i++) {
            RoomArr[r].SortCard.push(RoomArr[r].cardArr[i]);
        }
        RoomArr[r].SortCard.sort(function (a, b) {
            var dian_a = 0;
            var dian_b = 0;
            var sg_a = true;
            var sg_b = true;
            for (var i = 0; i < 3; i++) {
                if (a.card[i] < 110) sg_a = false;
                if (b.card[i] < 110) sg_b = false;
                if (a.card[i] >= 100) {
                    dian_a += 0;
                } else {
                    dian_a += Math.floor(a.card[i] / 10);
                }
                if (b.card[i] >= 100) {
                    dian_b += 0;
                } else {
                    dian_b += Math.floor(b.card[i] / 10);
                }
            }
            if (dian_a >= 10) dian_a = dian_a % 10;
            if (dian_b >= 10) dian_b = dian_b % 10;
            if (sg_a) dian_a = 10;
            if (sg_b) dian_b = 10;

            var dd = dian_b - dian_a;
            if (dian_a == dian_b) {
                a.card.sort(function (a, b) { return b - a });
                b.card.sort(function (a, b) { return b - a });
                var isDa = 0;
                isDa = a.card[0] - b.card[0];
                if (isDa != 0) {
                    if (isDa < 0) {
                        dd = 1;
                    } else {
                        dd = -1;
                    }
                } else {
                    var aa = a.card[0];
                    if (aa < a.card[1]) aa = a.card[1];
                    if (aa < a.card[2]) aa = a.card[2];
                    var bb = b.card[0];
                    if (bb < b.card[1]) bb = b.card[1];
                    if (bb < b.card[2]) bb = b.card[2];
                    if (aa > bb) dd = -1;
                    if (aa < bb) dd = 1;
                }

            }
            //判断豹子情况
            if (Math.floor(a.card[0] / 10) == Math.floor(a.card[1] / 10) && Math.floor(a.card[0] / 10) == Math.floor(a.card[2] / 10)) {
                if (Math.floor(b.card[0] / 10) == Math.floor(b.card[1] / 10) && Math.floor(b.card[0] / 10) == Math.floor(b.card[2] / 10)) {
                    if (Math.floor(b.card[0] / 10) < Math.floor(a.card[0] / 10)) {
                        //如果ab都是豹子   a大于b   a大
                        dd = -1;
                    } else {
                        dd = 1;
                    }
                } else {
                    dd = -1;
                }
            }
            if (Math.floor(b.card[0] / 10) == Math.floor(b.card[1] / 10) && Math.floor(b.card[0] / 10) == Math.floor(b.card[2] / 10)) {
                if (Math.floor(a.card[0] / 10) == Math.floor(a.card[1] / 10) && Math.floor(a.card[0] / 10) == Math.floor(a.card[2] / 10)) {
                    if (Math.floor(b.card[0] / 10) < Math.floor(a.card[0] / 10)) {
                        //如果ab都是豹子   a大于b   a大
                        dd = -1;
                    } else {
                        dd = 1;
                    }
                } else {
                    dd = 1;
                }
            }

            return dd;
        })

    }
    for (var i = 0; i < RoomArr.length; i++) {
        var AllGold = 0;
        var SortCard = RoomArr[i].SortCard;
        var BetArr = RoomArr[i].BetArr;
        var zhuozongArr = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];//每个桌的下注总额
        for (var j = 0; j < RoomArr[i].BetArr.length; j++) {//10个桌
            for (var k = 0; k < RoomArr[i].BetArr[j].length; k++) {//每个桌下注的人
                AllGold += RoomArr[i].BetArr[j][k].fama;
                zhuozongArr[j] += RoomArr[i].BetArr[j][k].fama;
            }
        }
        // console.log('每个桌的下注总额', zhuozongArr, AllGold);
        //去掉平台抽水
        AllGold = (1 - shoushui) * AllGold;
        AllGold = Math.floor(AllGold * 100) / 100;
        console.log('每个桌的下注总额', zhuozongArr, AllGold);
        //计算下注输赢
        for (var j = 0; j < SortCard.length; j++) {
            var id = SortCard[j].sortid;
            if (AllGold > 0) {
                if (AllGold > zhuozongArr[id] * 2) {
                    for (var k = 0; k < RoomArr[i].BetArr[id].length; k++) {
                        AllGold -= RoomArr[i].BetArr[id][k].fama * 2;
                        RoomArr[i].BetArr[id][k].zhengjia = RoomArr[i].BetArr[id][k].fama * 2;
                    }
                    yingZhuo.push(id);
                } else {
                    if (AllGold >= zhuozongArr[id]) {
                        for (var k = 0; k < RoomArr[i].BetArr[id].length; k++) {
                            RoomArr[i].BetArr[id][k].zhengjia = RoomArr[i].BetArr[id][k].fama;
                            AllGold -= RoomArr[i].BetArr[id][k].fama;
                        }

                        for (var k = 0; k < RoomArr[i].BetArr[id].length; k++) {
                            if (AllGold >= RoomArr[i].BetArr[id][k].fama) {
                                RoomArr[i].BetArr[id][k].zhengjia += RoomArr[i].BetArr[id][k].fama;
                                AllGold -= RoomArr[i].BetArr[id][k].fama;
                            } else {
                                RoomArr[i].BetArr[id][k].zhengjia += AllGold;
                                AllGold = 0;
                            }
                        }
                        yingZhuo.push(id);
                    } else {
                        console.log('RoomArr[i].BetArr[id]===', RoomArr[i].BetArr[id]);
                        if (RoomArr[i].BetArr[id]) {
                            for (var k = RoomArr[i].BetArr[id].length - 1; k >= 0; k--) {
                                if (AllGold >= RoomArr[i].BetArr[id][k].fama) {
                                    RoomArr[i].BetArr[id][k].zhengjia = RoomArr[i].BetArr[id][k].fama;
                                    AllGold -= RoomArr[i].BetArr[id][k].fama;
                                } else {
                                    RoomArr[i].BetArr[id][k].zhengjia += AllGold;
                                    AllGold = 0;
                                }
                            }
                        }
                    }
                }
            }

        }

        io.sockets.in(i).emit('显示赢的桌', yingZhuo);
        //多余10期移除掉第一期
        if (NextKJArr[i].length >= 10) NextKJArr[i].splice(0, 1);
        NextKJArr[i].push({ RoomArr: JSON.stringify(RoomArr[i]), kjArr: JSON.stringify(kjArr), qihao: JSON.stringify(newQiHao) });
        NextRecordArr[i].push({ roomid: i, qihao: newQiHao, RoomArr: JSON.stringify(RoomArr[i]) });
        SetMysql(RoomArr[i], '修改结算金币', i);
    }
}
server.listen(10009, function () {
    console.log('listening on *:' + 10009 + '   ....');
});
app.get('/', function (req, res) {
    res.send('<h1>Welcome Realtime Server</h1>');
});
var onlineuser = [];
var socket = io.on('connection', function (socket) {
    console.log('链接成功1111');
    socket.on('登录', function (data) {
        console.log('denglu', data)
        var ishas = false;
        data.sid = socket.id;
        for (var i = 0; i < RoomArr[data.roomid].OnRoomArr.length; i++) {
            if (data.id == RoomArr[data.roomid].OnRoomArr[i].id) {
                RoomArr[data.roomid].OnRoomArr[i].sid = socket.id;
                ishas = true;
            }
        }
        if (!ishas) {
            RoomArr[data.roomid].OnRoomArr.push(data);
            socket.join(data.roomid);
        }
        RoomArr[data.roomid].kjtime = timeDJS;
        RoomArr[data.roomid].STATE = STATE;
        // io.sockets.in(data.roomid).emit('登录', RoomArr[data.roomid]);
        socket.emit('登录', RoomArr[data.roomid]);
        // io.sockets.emit('总下注', BetArr);
    });
    socket.on('更新金币', function (data) {
        var BetArr = RoomArr[data.roomid].BetArr;
        var OnRoomArr = RoomArr[data.roomid].OnRoomArr;
        var roomid = data.roomid;
        for (var i = 0; i < OnRoomArr.length; i++) {
            if (data.id == OnRoomArr[i].id) {
                OnRoomArr[i].balance = data.balance;
            }
        }

    })
    socket.on('上轮记录', function (data) {
        socket.emit('上轮记录', NextRecordArr[data.roomid]);
    })
    socket.on('走势图', function (data) {
        socket.emit('走势图', NextKJArr[data.roomid]);
    })

    socket.on('下注', function (data) {
        if (STATE != '开始下注') return;
        console.log('下注', data);
        var BetArr = RoomArr[data.roomid].BetArr;
        var OnRoomArr = RoomArr[data.roomid].OnRoomArr;
        var roomid = data.roomid;
        var zong = data.xiazhuqian;
        var xiazhuzong = 0;
        //计算有没有下注
        for (var i = 0; i < BetArr.length; i++) {
            for (var j = 0; j < BetArr[i].length; j++) {
                if (data.id == BetArr[i][j].id) {
                    xiazhuzong += BetArr[i][j].fama;
                }
            }
        }
        var MyBalance = 0;
        var issuccess = false;
        for (var i = 0; i < OnRoomArr.length; i++) {
            if (data.id == OnRoomArr[i].id) {
                if (OnRoomArr[i].balance >= data.fama) {
                    OnRoomArr[i].balance -= data.fama;
                    // console.log(OnRoomArr[i].balance);
                } else {
                    issuccess = true;
                }
                MyBalance = OnRoomArr[i].balance;
            }
        }
        if (issuccess) return;
        // if (xiazhuzong + data.fama > zong) return;//如果下注的金额大于手上的金额
        //判断用户data.roomid 房，data.index桌有没有下注；
        // console.log('======', roomid, data.index, RoomArr[roomid].BetArr[data.index], '======', );
        var ishas = false;
        for (var i = 0; i < RoomArr[roomid].BetArr[data.index].length; i++) {
            if (data.id == RoomArr[roomid].BetArr[data.index][i].id) {
                //如果有下注下注金额加data.fama
                ishas = true;
                RoomArr[roomid].BetArr[data.index][i].fama += data.fama;
            }
        }
        //如果本桌没有下注
        if (!ishas) RoomArr[roomid].BetArr[data.index].push(data);
        // socket.emit('下注成功', data);
        io.sockets.in(data.roomid).emit('下注成功', data);


        socket.emit('score', MyBalance);

        io.sockets.in(data.roomid).emit('总下注', RoomArr[roomid].BetArr);
        // io.sockets.emit('总下注', BetArr);
        SetMysql(data, '下注');
    })
    socket.on('撤销下注', function (data) {
        // console.log(data);
        if (STATE != '开始下注') return;
        var roomid = data.roomid;
        var BetArr = RoomArr[roomid].BetArr;
        var BetZong = 0;
        for (var i = 0; i < BetArr.length; i++) {
            for (var j = 0; j < BetArr[i].length; j++) {
                if (data.id == BetArr[i][j].id) {
                    BetZong += BetArr[i][j].fama;
                    SetMysql(BetArr[i][j], '撤销下注', roomid);
                    BetArr[i].splice(j, 1);
                    j--;
                }
            }
        }
        var MyBalance = 0;
        for (var i = 0; i < RoomArr[roomid].OnRoomArr.length; i++) {
            if (data.id == RoomArr[roomid].OnRoomArr[i].id) {
                RoomArr[roomid].OnRoomArr[i].balance = Number(RoomArr[roomid].OnRoomArr[i].balance) + Number(BetZong);
                // console.log(RoomArr[roomid].OnRoomArr[i].balance, BetZong);
                MyBalance = Number(RoomArr[roomid].OnRoomArr[i].balance);
            }
        }
        socket.emit('score', MyBalance);
        io.sockets.in(data.roomid).emit('总下注', RoomArr[roomid].BetArr);
        socket.emit('撤销下注成功', data);
    });
    socket.on('disconnect', function () {
        for (var i = 0; i < RoomArr.length; i++) {
            for (var j = 0; j < RoomArr[i].OnRoomArr.length; j++) {
                if (socket.id == RoomArr[i].OnRoomArr[j].sid) {
                    RoomArr[i].OnRoomArr.splice(j, 1);
                }
            }
        }
    });
});
function SetMysql(data, type, kjnum) {
    var conn = mysql.createConnection(options);
    var ntime = Date.parse(new Date()) / 1000;
    if (type == '下注') {
        var sql_cou = "update tp_user_list_kc set balance=balance-" + data.fama + " where id=" + data.id;
        // console.log(sql_cou);
        conn.query(sql_cou, function (ers, res) {
            // console.log("-----修改下注金币------");
        });
    }
    if (type == '撤销下注') {
        var sql_cou = "update tp_user_list_kc set balance=balance+" + data.fama + " where id=" + data.id;
        // console.log(sql_cou);
        conn.query(sql_cou, function (ers, res) {
            // console.log("-----修改下注金币------");
            // socket.emit('撤销下注成功', data);
            io.sockets.in(kjnum).emit('总下注', RoomArr[kjnum].BetArr);
        });
    }
    if (type == '修改结算金币') {
        console.log("-----修改下注金币------");
        var BetArr = RoomArr[kjnum].BetArr;
        for (var i = 0; i < BetArr.length; i++) {
            for (var j = 0; j < BetArr[i].length; j++) {
                var sql_cou = "update tp_user_list_kc set balance=balance+" + BetArr[i][j].zhengjia + " where id=" + BetArr[i][j].id;
                conn.query(sql_cou, function (ers, res) {
                    console.log("-----修改下注金币------", sql_cou);
                });
                for (var k = 0; k < RoomArr[kjnum].OnRoomArr.length; k++) {
                    if (BetArr[i][j].id == RoomArr[kjnum].OnRoomArr[k].id) {
                        RoomArr[kjnum].OnRoomArr[k].balance += BetArr[i][j].zhengjia;
                        BetArr[i][j].xiazhuqian = RoomArr[kjnum].OnRoomArr[k].balance;
                        //BetArr[i][j].dian = RoomArr[kjnum].cardArr[i].card;
                       BetArr[i][j].dian = '没获取到';
                      console.log(RoomArr[kjnum].cardArr[i],'------');
                        if (RoomArr[kjnum].cardArr[i]) {
                            BetArr[i][j].dian = RoomArr[kjnum].cardArr[i].card;
                        }
                    }
                }
                var time = Date.parse(new Date()) / 1000;
                //添加下注纪录
                var sql_xh = "INSERT INTO `tp_xiazhujilu_kc` (`userid`,`roomid`,`qihao`,`zhuohao`,`xiazhuzong`,`zengjia`,`time`,`dianshu`,`xzhbalance`) VALUES ('" +
                    BetArr[i][j].id + "','" + kjnum + "','" + newQiHao + "','" + i + "','"
                    + BetArr[i][j].fama + "','" + BetArr[i][j].zhengjia + "','" + time + "','" + BetArr[i][j].dian + "','" + BetArr[i][j].xiazhuqian + "')";
                conn.query(sql_xh, function (ers, res) {
                    console.log(sql_xh);
                    // console.log("添加消耗记录表");
                });

                var requestData = { id: BetArr[i][j].id, jine: BetArr[i][j].fama };
                 console.log('==111111==',BetArr[i][j].id);
                 console.log(requestData);
                request({
                    url: GameUrl + 'index.php/index/Ajax/getxiazhu',
                    method: "POST",
                    json: true,
                    headers: {
                        "content-type": "application/json",
                    },
                    body: requestData
                    // body: requestData
                }, function (error, response, body) {
                    if (!error && response.statusCode == 200) {
                        console.log('=====yyjyj===', body);
                    }
                });


            }
        }
		RoomArr[kjnum].BetArr = [[], [], [], [], [], [], [], []];
    }
    //断开连接
    conn.end()
}
function onDianNum(data) {
    console.log('-------', data)

    if (data.card[0] > 110 && data.card[1] > 110 && data.card[2] > 110) return 10;
    var dian1 = Math.floor(data.card[0] / 10);
    if (dian1 >= 10) dian1 = 0;
    var dian2 = Math.floor(data.card[1] / 10);
    if (dian2 >= 10) dian2 = 0;
    var dian3 = Math.floor(data.card[2] / 10);
    if (dian3 >= 10) dian3 = 0;
    var dian = dian1 + dian2 + dian3;
    console.log('计算点数----', data.card, dian % 10);
    // console.log(dian1, dian2, dian3);
    return dian % 10;
}