<!DOCTYPE html>
<html>

<head>
    <title>Fabric Demo</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins|Inter|Roboto">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.2.4/fabric.min.js"></script>

    <style>
        #c {
            border: 1px solid black;
        }

        #canvas-container {
            width: 960px;
            height: 540px;
        }
    </style>

</head>

<body>

    <h2>Designeer</h2>

    <input type="file" id="bgInput">
    <button onclick="addTextBox()">Add Text</button>

    <button onclick="setLandscape()">Landscape</button>
    <button onclick="setPortrait()">Portrait</button>

    <label>Font family:</label>
    <select id="fontFamily">
        <option value="Poppins">Poppins</option>
        <option value="Inter">Inter</option>
        <option value="Roboto">Roboto</option>
        <option value="Montserrat">Montserrat</option>
    </select>

    <label>Font size:</label>
    <input type="number" id="fontSizePicker" min="10" max="200" value="42">

    <label>Font Color:</label>
    <input type="color" id="textColorPicker" value="#000000">

    <button onclick="downloadImage()">Export 1080p</button>

    <div id="canvas-container">
        <canvas id="c"></canvas>
    </div>

    <script>
        var canvas = new fabric.Canvas('c', {
            width: 1920,
            height: 1080,
            preserveObjectStacking: true
        });

        // The zoom is 0.5 for the visual preview
        var initialZoom = 0.5;
        canvas.setZoom(initialZoom);

        // The canvas element must be sized down visually
        // Fabric.js typically handles this, but explicitly setting the style 
        // or using a container is best for layout. Let's rely on setDimensions.
        canvas.setDimensions({
            width: 1920 * initialZoom,
            height: 1080 * initialZoom
        });

        document.getElementById('bgInput').addEventListener('change', function(e) {
            var reader = new FileReader();
            reader.onload = function(f) {
                var data = f.target.result;
                fabric.Image.fromURL(data, function(img) {
                    // Scale the image to fit the canvas
                    img.set({
                        left: 0,
                        top: 0,
                        selectable: false
                    });
                    img.scaleToWidth(canvas.getWidth() / initialZoom);
                    img.scaleToHeight(canvas.getHeight() / initialZoom);
                    canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas));
                });
            };
            reader.readAsDataURL(e.target.files[0]);
        });

        var textCount = 0;

        function addTextBox() {
            var text = new fabric.Textbox("Type here.", {
                left: 50,
                top: 50 + (textCount * 60),
                fill: '#000000', // default
                editable: true,
                fontSize: 42
            });

            canvas.add(text);
            canvas.setActiveObject(text);
            text.enterEditing();
            textCount++;
            canvas.renderAll();
        }

        // delete selected on keyboard
        document.addEventListener('keydown', function(e) {
            if (e.key === "Delete") {
                var obj = canvas.getActiveObject();
                if (obj) {
                    canvas.remove(obj);
                    canvas.discardActiveObject();
                    canvas.renderAll();
                }
            }
        });

        canvas.on('object:selected', function(e) {
            canvas.bringToFront(e.target);
        });

        // Disable the browser right click menu on canvas
        canvas.upperCanvasEl.addEventListener('contextmenu', function(e) {
            e.preventDefault();

            const pointer = canvas.getPointer(e);
            const obj = canvas.findTarget(e);

            if (obj) {
                canvas.remove(obj);
                canvas.discardActiveObject();
                canvas.renderAll();
            }
        });

        var initialZoom = 0.5;

        function applyCanvasSize(w, h) {
            canvas.setWidth(w);
            canvas.setHeight(h);

            canvas.setZoom(initialZoom);
            canvas.setDimensions({
                width: w * initialZoom,
                height: h * initialZoom
            });

            if (canvas.backgroundImage) {
                canvas.backgroundImage.scaleToWidth(w);
                canvas.backgroundImage.scaleToHeight(h);
            }

            canvas.renderAll();
        }

        function setLandscape() {
            // Check if canvas has objects or background
            const hasObjects = canvas.getObjects().length > 0;
            const hasBackground = !!canvas.backgroundImage;

            if (hasObjects || hasBackground) {
                const confirmClear = confirm(
                    "Changing orientation will clear the canvas. Do you want to continue?"
                );

                if (!confirmClear) {
                    return; // stop, do nothing
                }

                // Clear canvas
                canvas.clear();
            }

            // Apply new size
            applyCanvasSize(1920, 1080);
        }

        function setPortrait() {
            applyCanvasSize(1080, 1920);
        }

        const textColorPicker = document.getElementById('textColorPicker');
        const fontFamilySelect = document.getElementById('fontFamily');
        const fontSizePicker = document.getElementById('fontSizePicker');

        // font color change
        textColorPicker.addEventListener('input', function() {
            const obj = canvas.getActiveObject();
            if (obj && obj.type === 'textbox') {
                obj.set('fill', this.value);
                canvas.renderAll();
            }
        });

        // font family change
        fontFamilySelect.addEventListener('change', function() {
            const obj = canvas.getActiveObject();
            if (obj && obj.type === 'textbox') {
                obj.set('fontFamily', this.value);
                canvas.renderAll();
            }
        });

        // font size change
        fontSizePicker.addEventListener('input', function() {
            const obj = canvas.getActiveObject();
            if (obj && obj.type === 'textbox') {
                obj.set('fontSize', parseInt(this.value));
                canvas.renderAll();
            }
        });

        // export 1080p image
        function downloadImage() {
            // IMPORTANT: temporarily remove zoom for export
            const zoom = canvas.getZoom();
            canvas.setZoom(1);

            canvas.renderAll();

            const dataURL = canvas.toDataURL({
                format: 'jpeg',
                quality: 1.0,
                multiplier: 1 // EXACT 1920x1080 (internal canvas size)
            });

            // restore zoom for UI
            canvas.setZoom(zoom);
            canvas.renderAll();

            // create download link
            const link = document.createElement('a');
            link.href = dataURL;
            link.download = 'design-1080p.jpg';
            link.click();
        }
    </script>

</body>

</html>