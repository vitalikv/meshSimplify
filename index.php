<!DOCTYPE html>
<html lang="en">
	<head>
		<title>three.js webgl - modifier - Subdivisions using Loop Subdivision Scheme</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
	</head>
	<body>

		<script src="js/three.min.js"></script>
		<script src="js/OrbitControls.js"></script>
		<script src="js/GLTFLoader.js"></script>
		<script src="js/SimplifyModifier.js"></script>

		<script src="js/loader/inflate.min.js"></script>
		<script src="js/loader/FBXLoader.js"></script>		
		<script src="js/OBJLoader.js"></script>
		
		<script>
			var renderer, scene, camera;
			init();
			function init() {

				renderer = new THREE.WebGLRenderer( { antialias: true } );
				renderer.setPixelRatio( window.devicePixelRatio );
				renderer.setSize( window.innerWidth, window.innerHeight );
				document.body.appendChild( renderer.domElement );
				scene = new THREE.Scene();
				scene.background = new THREE.Color( 0xffffff );
				camera = new THREE.PerspectiveCamera( 40, window.innerWidth / window.innerHeight, 1, 1000 );
				camera.position.z = 15;
				var controls = new THREE.OrbitControls( camera, renderer.domElement );
				controls.addEventListener( 'change', render ); // use if there is no animation loop
				//controls.enablePan = false;
				//controls.enableZoom = false;
				scene.add( new THREE.AmbientLight( 0xffffff, 0.2 ) );
				var light = new THREE.PointLight( 0xffffff, 0.7 );
				camera.add( light );
				scene.add( camera );

				window.addEventListener( 'resize', onWindowResize, false );
				
				//---------------FBX----------
				
				var loader = new THREE.FBXLoader();
				loader.load( 'export/3.fbx', function ( obj ) 
				{ 					
					obj = obj.children[0];
					obj.scale.set(0.1,0.1,0.1); 
					obj.position.set(5,0,0);					
					scene.add( obj );
					
					console.log(1, obj);
	
					objClone = obj.clone();
					
					var obj = obj.clone();
					objClone2 = obj;										
					
					upResizeGeometry(obj, 0.6);


					obj.scale.set(0.1,0.1,0.1);
					obj.position.x = -3;		
					obj.position.z = 0;
	
	
					scene.add( obj );
					console.log(2, obj);
					render();
				});	
				
				//---------------FBX----------
				

var prog = 0.05;
var objClone = null;
var objClone2 = null;

document.body.addEventListener("keydown", function (e) 
{
	var step = 0.05;
	
	if (e.keyCode == 38) { if(prog+step<0.95){ prog+=step; }}
	if (e.keyCode == 40) { if(prog-step>0.05){ prog-=step; }}
	
	
	
	scene.remove(objClone2);
	
	var obj = objClone.clone();
	upResizeGeometry(obj, prog);
	obj.scale.set(0.1,0.1,0.1);
	obj.position.x = -3;		
	obj.position.z = 0;
	scene.add( obj );
	
	objClone2 = obj;
	
	console.log(prog);
});

function upResizeGeometry(obj, step)
{
	obj.traverse( function ( child ) 
	{
		if ( child.isMesh ) 
		{ 
			var count = child.geometry.attributes.position.count;

			MeshGeometry = new THREE.Geometry().fromBufferGeometry( child.geometry.clone() );
			MeshGeometry.computeFaceNormals();
			MeshGeometry.mergeVertices();
			MeshGeometry.computeVertexNormals();

			var modifier = new THREE.SimplifyModifier();
			child.geometry = modifier.modify(MeshGeometry, MeshGeometry.vertices.length * step | 0, true);
			child.geometry.computeFaceNormals();
			child.geometry.computeVertexNormals();
			
			//material1 = new THREE.MeshLambertMaterial( {color: 0x00ff00, wireframe:false} )
			//mesh = new THREE.Mesh(simplified, material1);
			//scene.add(mesh);
			
			console.log(child.name, count, child.geometry.attributes.position.count);
		}
	} );	
}
				
				
			if(1==2)
			{
				new THREE.OBJLoader().load						
				( 
					'export/nasos.obj', 
					function ( object ) 
					{		
						
						
						
						var obj = object.children[0];					
		
						obj.scale.set(10.1, 10.1, 10.1);
						
						obj.material = new THREE.MeshLambertMaterial( {color: 0x00ff00, wireframe:false} );
						scene.add(obj);
						
			MeshGeometry = new THREE.Geometry().fromBufferGeometry( obj.geometry );
			MeshGeometry.computeFaceNormals();
			MeshGeometry.mergeVertices();
			MeshGeometry.computeVertexNormals();

			var modifier = new THREE.SimplifyModifier();
			var simplified = modifier.modify(MeshGeometry, MeshGeometry.vertices.length * 0.30 | 0, true);
			simplified.computeFaceNormals();
			simplified.computeVertexNormals();					
						
			material1 = obj.material.clone(); 
			mesh = new THREE.Mesh(simplified, material1);
			scene.add(mesh);
					

			mesh.scale.set(10.1, 10.1, 10.1);
			mesh.position.x = -4;
			
						console.log(4, mesh.geometry.attributes.position.count, obj.geometry.attributes.position.count);
						console.log(22, mesh, obj);
					} 
				);				

			}				
				
				

				if(1==2)
				{
					var geometry = new THREE.BoxGeometry( 10, 10, 10 );
					var material = new THREE.MeshLambertMaterial( {color: 0x00ff00} );
					var cube = new THREE.Mesh( geometry, material );
					scene.add( cube );	

					var modifier = new THREE.SimplifyModifier();
					var count_1 = geometry.vertices.length;
					var count = Math.floor( geometry.vertices.length * 0.2 );
					cube.geometry = modifier.modify( cube.geometry, count );
					
					console.log(333, modifier.modify( cube.geometry, count ));
				}	
				
				
				render();
			}
			function onWindowResize() {
				renderer.setSize( window.innerWidth, window.innerHeight );
				camera.aspect = window.innerWidth / window.innerHeight;
				camera.updateProjectionMatrix();
				render();
			}
			function render() {
				renderer.render( scene, camera );
			}
		</script>

	</body>
</html>