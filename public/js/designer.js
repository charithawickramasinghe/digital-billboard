var canvas = new fabric.Canvas('responsive-canvas', {
    width: 1920,
    height: 1080,
    preserveObjectStacking: true
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

document.getElementById('bgInput').addEventListener('change', function (e) {
    var reader = new FileReader();
    reader.onload = function (f) {
        var data = f.target.result;
        fabric.Image.fromURL(data, function (img) {
            // Scale the image to fit the canvas
            img.set({
                left: 0,
                top: 0,
                selectable: false
            });
            img.scaleToWidth(canvas.getWidth());
            img.scaleToHeight(canvas.getHeight());
            canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas));
        });
    };
    reader.readAsDataURL(e.target.files[0]);
});

// delete selected on keyboard
document.addEventListener('keydown', function (e) {
    if (e.key === "Delete") {
        var obj = canvas.getActiveObject();
        if (obj) {
            canvas.remove(obj);
            canvas.discardActiveObject();
            canvas.renderAll();
        }
    }
});

canvas.on('object:selected', function (e) {
    canvas.bringToFront(e.target);
});

// Disable the browser right click menu on canvas
canvas.upperCanvasEl.addEventListener('contextmenu', function (e) {
    e.preventDefault();

    const pointer = canvas.getPointer(e);
    const obj = canvas.findTarget(e);

    if (obj) {
        canvas.remove(obj);
        canvas.discardActiveObject();
        canvas.renderAll();
    }
});

const textColorPicker = document.getElementById('textColorPicker');
const fontFamilySelect = document.getElementById('fontFamily');
const fontSizePicker = document.getElementById('fontSizePicker');

// color change
textColorPicker.addEventListener('input', function () {
    const obj = canvas.getActiveObject();
    if (!obj) return;

    const color = this.value;

    switch (obj.type) {
        case 'textbox':
            obj.set('fill', color);
            break;

        case 'rect':
        case 'circle':
            // Set border color
            obj.set('stroke', color);

            // OR if you want filled shapes:
            // obj.set('fill', color);
            break;

        case 'path':
        case 'line':
            obj.set('stroke', color);
            break;

        case 'image':
            // optional: tint the image
            // obj.filters = [new fabric.Image.filters.Tint({ color })];
            // obj.applyFilters();
            break;
    }

    canvas.renderAll();
});


// font family change
fontFamilySelect.addEventListener('change', function () {
    const obj = canvas.getActiveObject();
    if (obj && obj.type === 'textbox') {
        obj.set('fontFamily', this.value);
        canvas.renderAll();
    }
});

// font size change
fontSizePicker.addEventListener('input', function () {
    const obj = canvas.getActiveObject();
    if (obj && obj.type === 'textbox') {
        obj.set('fontSize', parseInt(this.value));
        canvas.renderAll();
    }
});

// export 1080p image
function downloadImage() {

    // If nothing is drawn (no objects and no background)
    if (canvas.getObjects().length === 0 && !canvas.backgroundImage) {
        console.log("Canvas is empty. Export skipped.");
        return;
    }

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

let imageCount = 0;
// add image
document.getElementById('imgInput').addEventListener('change', function (e) {
    const reader = new FileReader();

    reader.onload = function (f) {
        const data = f.target.result;

        fabric.Image.fromURL(data, function (img) {

            const offset = imageCount * 40; // prevents overlap

            img.set({
                left: 100 + offset,
                top: 100 + offset,
                selectable: true,
                hasControls: true,
                hasBorders: true
            });

            img.scaleToWidth(300); // PNG transparency is preserved

            canvas.add(img);
            canvas.setActiveObject(img);
            canvas.renderAll();

            imageCount++;
        });
    };

    reader.readAsDataURL(e.target.files[0]);
});

let shapeCount = 0;

function addSquare() {
    const offset = shapeCount * 40;

    const square = new fabric.Rect({
        left: 100 + offset,
        top: 100 + offset,
        width: 200,
        height: 200,
        fill: 'transparent',
        stroke: 'black',
        strokeWidth: 3,
        selectable: true
    });

    canvas.add(square);
    canvas.setActiveObject(square);
    canvas.renderAll();
    shapeCount++;
}

function addCircle() {
    const offset = shapeCount * 40;

    const circle = new fabric.Circle({
        left: 100 + offset,
        top: 100 + offset,
        radius: 100,
        fill: 'transparent',
        stroke: 'black',
        strokeWidth: 3,
        selectable: true
    });

    canvas.add(circle);
    canvas.setActiveObject(circle);
    canvas.renderAll();
    shapeCount++;
}

function setLandscape() {

    // If already landscape, do nothing
    if (canvas.width === 1920 && canvas.height === 1080) {
        console.log("Already in landscape.");
        return;
    }

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
        canvas.clear();
    }
    applyCanvasSize(1920, 1080);
}

function setPortrait() {

    // If already portrait, do nothing
    if (canvas.width === 1080 && canvas.height === 1920) {
        console.log("Already in portrait.");
        return;
    }

    const hasObjects = canvas.getObjects().length > 0;
    const hasBackground = !!canvas.backgroundImage;

    if (hasObjects || hasBackground) {
        const confirmClear = confirm(
            "Changing orientation will clear the canvas. Do you want to continue?"
        );

        if (!confirmClear) {
            return;
        }
        canvas.clear();
    }
    applyCanvasSize(1080, 1920);
}

function applyCanvasSize(w, h) {
    // Set the logical canvas size
    canvas.setWidth(w);
    canvas.setHeight(h);

    // Adjust background image if it exists
    if (canvas.backgroundImage) {
        canvas.backgroundImage.scaleToWidth(w);
        canvas.backgroundImage.scaleToHeight(h);
    }

    canvas.renderAll();
}
