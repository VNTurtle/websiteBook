var binElement = document.getElementById('Model_bin');
var binName = binElement ? binElement.value : null;
console.log(binName);

var modelElement = document.getElementById('Model');
var modelName = modelElement ? modelElement.value : null;
console.log(modelName);

if(binName!=null){
    window.addEventListener('DOMContentLoaded', function() {
        var canvas = document.getElementById('3D-Book');
        var engine = new BABYLON.Engine(canvas, true);
    
        // Tạo scene
        var scene = new BABYLON.Scene(engine);
        // Đặt màu nền
        scene.clearColor = new BABYLON.Color3(0, 0.749, 0.984);
        // Tạo camera
        var camera = new BABYLON.ArcRotateCamera('camera', Math.PI, Math.PI / 3, 10, BABYLON.Vector3.Zero(), scene);
        camera.attachControl(canvas, true);
        camera.wheelPrecision = 50; // Điều chỉnh tốc độ zoom
    
        // Thiết lập giá trị minZ và maxZ
        camera.minZ = 0.1; // Khoảng cách gần nhất mà camera có thể hiển thị
        camera.maxZ = 10000; // Khoảng cách xa nhất mà camera có thể hiển thị
    
    
        // Ngăn chặn hành động mặc định của trình duyệt khi cuộn trên thẻ canvas
        canvas.addEventListener('wheel', function(event) {
            event.preventDefault();
        }, {
            passive: false
        });
        var cameraStateFromMySQL = {
            alpha: parseFloat(cameraState2.alpha.replace(/'/g, '')),
            beta: parseFloat(cameraState2.beta.replace(/'/g, '')),
            radius: parseFloat(cameraState2.radius.replace(/'/g, '')),
            target: {
                x: parseFloat(cameraState2.target.x.replace(/'/g, '')),
                y: parseFloat(cameraState2.target.y.replace(/'/g, '')),
                z: parseFloat(cameraState2.target.z.replace(/'/g, ''))
            }
        };
        console.log(cameraStateFromMySQL);
        // Sử dụng dữ liệu từ MySQL để cập nhật camera
        if (cameraStateFromMySQL) {
            camera.alpha = cameraStateFromMySQL.alpha;
            camera.beta = cameraStateFromMySQL.beta;
            camera.radius = cameraStateFromMySQL.radius;
            camera.setTarget(new BABYLON.Vector3(cameraStateFromMySQL.target.x, cameraStateFromMySQL.target.y, cameraStateFromMySQL.target.z));
        }
        // Tạo ánh sáng
        var light = new BABYLON.HemisphericLight('light', new BABYLON.Vector3(0, 1, 0), scene);
    
        // Tải mô hình từ Blender
    
    
        
        // Tạo đường dẫn đầy đủ với 'Modun/' trước tên file
        BABYLON.SceneLoader.ImportMesh('', '', modelName, scene, function(meshes) {
            // Meshes là một mảng chứa các mesh trong mô hình
            // Bạn có thể thực hiện các thao tác khác trên các mesh ở đây
    
            // Chỉnh kích thước mô hình
            var model = meshes[0];
            model.scaling = new BABYLON.Vector3(2.5, 2.5, 2.5);
            model.position = new BABYLON.Vector3(0, -3, 0);
            // Chạy vòng lặp chính
            engine.runRenderLoop(function() {
                scene.render();
            });
        });
    
        // Xử lý sự kiện khi cửa sổ trình duyệt thay đổi kích thước
        window.addEventListener('resize', function() {
            engine.resize();
        });
    });
}


    $('.slider-for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.slider-nav'
    });
    $('.slider-nav').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: '.slider-for',
        dots: false,
        arrows: false,
        centerMode: true,
        centerPadding: '60px',
        focusOnSelect: true,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: false
                }
            },
            {
                breakpoint: 600,
                settings: {
                    arrows: false,
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    arrows: false,
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            }
        ]
    });
    