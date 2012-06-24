var chatPort = 9000;
var io = require('socket.io').listen(chatPort);

io.sockets.on('connection',function(socket){
	io.enable('browser client minification');  // send minified client
	io.enable('browser client etag');          // apply etag caching logic based on version number
	io.enable('browser client gzip');

	io.set('log level',1);
	io.set('transports', [                     // enable all transports (optional if you want flashsocket)
		'websocket'
	  , 'htmlfile'
	  , 'xhr-polling'
	  , 'jsonp-polling'
	]);

	var pname = '';

	socket.on('chat2',function(name,fn){
		fn(name);
	})

	socket.on('chat',
		function(data)
		{
			//console.log(data);
			socket.get('nickname', function (err, pname) {
				socket.broadcast.emit('chat',{
					data: data,
					sender_id: pname,
				})
			});
		}
	)

	socket.on('set nickname',function(name){
		socket.set('nickname',name,
			function()
			{
				pname = name;
			}
		);
	})

	socket.on('disconnect', function () { 
		socket.get('nickname', function (err, pname) {
		  //console.log('One user disconnected',pname);
		  socket.broadcast.emit('disconnect',pname);
		});
	});

	socket.on('user connect', 
		function (data) 
		{ 
			socket.broadcast.emit('user connect',data);
		}
	);
	
	socket.on('get timeline', 
		function (data) 
		{ 
			socket.broadcast.emit('get timeline',data);
		}
	);

	socket.on('change status',
		function(data)
		{
			socket.broadcast.emit('change status',data);
		}
	);
})

//console.log('Chat server is now online. Running on Port:'+chatPort);
