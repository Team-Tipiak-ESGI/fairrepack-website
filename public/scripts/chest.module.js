import * as THREE from '/three/build/three.module.js';
import { FBXLoader } from '/three/examples/jsm/loaders/FBXLoader.js';

let camera, scene, renderer;

const clock = new THREE.Clock();

let chest, phone;
let animation_duration = 0;
window.webgl_animated = false;


function init() {
    const container = document.getElementById("container");
    const boundingRect = container.getBoundingClientRect();

    camera = new THREE.PerspectiveCamera(45, boundingRect.width / boundingRect.height, 1, 2000);
    camera.position.set(250, 150, 500);
    camera.rotation.y = Math.PI * 0.15;

    scene = new THREE.Scene();
    scene.background = null;

    const hemiLight = new THREE.HemisphereLight(0xffffff, 0x444444);
    hemiLight.position.set(0, 200, 0);
    scene.add(hemiLight);

    const dirLight = new THREE.DirectionalLight(0xffffff);
    dirLight.position.set(0, 200, 200);
    dirLight.castShadow = true;
    dirLight.shadow.camera.top = 180;
    dirLight.shadow.camera.bottom = - 100;
    dirLight.shadow.camera.left = - 120;
    dirLight.shadow.camera.right = 120;
    scene.add(dirLight);

    const texture = new THREE.TextureLoader().load('public/models/Diffuse.png');

    // model
    const loader = new FBXLoader();
    loader.load('./public/models/chest.fbx', function (object) {
        chest = new THREE.AnimationMixer(object);
        const action = chest.clipAction(object.animations[0]);
        action.play();

        object.traverse(function (child) {
            if (child.isMesh) {
                child.castShadow = true;
                child.receiveShadow = true;

                child.material.map = texture;
            }
        });
        scene.add(object);
    });

    loader.load('./public/models/phone.fbx', function (object) {
        object.castShadow = true;
        object.receiveShadow = true;

        object.position.x = 0;
        object.position.y = 200;
        object.position.z = 0;

        object.scale.x = .5;
        object.scale.y = .5;
        object.scale.z = .5;

        object.rotation.y = Math.PI * 1.5;

        phone = object;

        scene.add(object);
    });

    renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
    renderer.setPixelRatio(window.devicePixelRatio);
    renderer.setSize(boundingRect.width, boundingRect.height);
    renderer.shadowMap.enabled = true;
    container.appendChild(renderer.domElement);
    renderer.setClearColor(0x000000, 0);

    window.addEventListener('resize', onWindowResize);

}

function onWindowResize() {
    const container = document.getElementById("container");
    const boundingRect = container.getBoundingClientRect();

    camera.aspect = boundingRect.width / boundingRect.height;
    camera.updateProjectionMatrix();

    renderer.setSize(boundingRect.width, boundingRect.height);
}

function animate() {
    requestAnimationFrame(animate);
    const delta = clock.getDelta();

    if (window.webgl_animated && chest && animation_duration < (1/30) * 35 || phone && phone.position.y < -100 && animation_duration < (1 / 30) * 75) {
        chest.update(delta);
        animation_duration += delta;
    } else if (window.webgl_animated && phone && phone.position.y > -100) {
        phone.position.y += -200 * delta;
        phone.rotation.y += delta * 2;
    }

    renderer.render(scene, camera);
}

window.webgl_init = init;
window.webgl_animate = animate;
