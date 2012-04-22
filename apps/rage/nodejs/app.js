var port = 8888;

var io = require('socket.io').listen(port);
var net = require('net');

// Setup
io.enable('browser client minification');  
io.enable('browser client etag');       
io.enable('browser client gzip');

io.set('log level',1);
io.set('transports', ['websocket','htmlfile','xhr-polling','jsonp-polling']);

var chat = io
	.of('/chat')
	.on('connection',function(socket){
		
		socket.on('send',function(data){
			socket.broadcast.emit('receive_'+data.toid,data);
			//console.log(data);
		})
		
		socket.on('istyping',function(data){
			socket.broadcast.emit('istyping_'+data.toid,data);
			//console.log(data);
		})
		
	})

var timeline = io
	.of('/timeline')
	.on('connection',function(socket){
		
		socket.on('post',function(data){
			
			socket.broadcast.emit('receive',data);
			
		});
	
	})

var ostatus = io
	.of('/ostatus')
	.on('connection',function(socket){
		
		socket.on('user connecting',function(data){
			
			socket.broadcast.emit('user connected',data);
			socket.set('userid',data.id,function(){});
			
			var xdb =
				{
					id		:	data.id,
					status	:	1
				}
			
			updateUser(xdb);
		
		})
		
		socket.on('disconnect',function(){
			socket.get('userid',function(err,userid){
				socket.broadcast.emit('user disconnected',{id:userid});
				
				var xdb =
				{
					id		:	userid,
					status	:	0
				}
			
				updateUser(xdb);
				
			})
			
		})
		
		socket.on('new status',function(data){
			//console.log(data);
			socket.broadcast.emit('change status',data);
			
		})

	})


// Database ----------------------------------

var mongodb = require('mongodb');
var server = new mongodb.Server("127.0.0.1",27017,{});
var ObjectID = require('mongodb').ObjectID;
var client = new mongodb.Db('hives',server,{});

function updateUser(data)
{

	client.open(function(err,client){
		
		var users = new mongodb.Collection(client,'users');
		var userid = new ObjectID(data.id);
		
		users.update({'_id':userid},{$set:{'online':data.status}},{safe:true},
			function(err)
			{
				if(err) console.warn(err.message);
				//else console.log('Set Online');
				client.close();
			}
		);
		
	})
}


// Telnet
/*
var tcpserver = net.createServer(function(socket){
	socket.write('Hello\n');
	socket.write('world\n');
	
	socket.on('data',function(data){
		
		socket.write(data);
	})
})

tcpserver.listen(7777);

*/
