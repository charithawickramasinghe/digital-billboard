
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Menu Card Designer</title>
  <style>
    body { font-family: Arial, Helvetica, sans-serif; margin: 12px; }
    #canvas-container { border: 1px solid #ddd; display:inline-block; }
    .controls { margin-bottom: 12px; }
    .btn { padding: 8px 12px; margin-right:8px; cursor:pointer }
  </style>
</head>
<body>
  <h2>Menu Card Designer</h2>

  <div class="controls">
    <label>Orientation:
      <select id="orientation">
        <option value="landscape">Landscape (1200×800)</option>
        <option value="portrait">Portrait (800×1200)</option>
      </select>
    </label>

    <label>Custom Width: <input id="custom-w" type="number" style="width:80px" placeholder="px"></label>
    <label>Custom Height: <input id="custom-h" type="number" style="width:80px" placeholder="px"></label>
    <button id="apply-size" class="btn">Apply Size</button>

    <input id="bgfile" type="file" accept="image/*" />
    <button id="add-text" class="btn">Add Text</button>
    <button id="download" class="btn">Download JPG</button>
    <button id="save-server" class="btn">Save to Server</button>
  </div>

  <div id="canvas-container">
    <canvas id="c"></canvas>
  </div>

  <p>Click text to edit, drag to move, use corner handles to resize/rotate. Right-click object -> delete (or press Delete key).</p>

  <!-- Fabric.js CDN -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/6.0.0/fabric.min.js"></script>
  <script>
    const landscape = { w: 1200, h: 800 };
    const portrait = { w: 800, h: 1200 };

    const canvasEl = document.getElementById('c');
    const canvas = new fabric.Canvas('c', { backgroundColor: 'transparent' });

    function setCanvasSize(w, h) {
      canvas.setWidth(w);
      canvas.setHeight(h);
      canvas.calcOffset();
      document.getElementById('canvas-container').style.width = w + 'px';
    }

    // initial
    setCanvasSize(landscape.w, landscape.h);

    // change orientation
    document.getElementById('orientation').addEventListener('change', (e) => {
      const val = e.target.value;
      if (val === 'landscape') setCanvasSize(landscape.w, landscape.h);
      else setCanvasSize(portrait.w, portrait.h);
    });

    document.getElementById('apply-size').addEventListener('click', () => {
      const w = parseInt(document.getElementById('custom-w').value) || canvas.getWidth();
      const h = parseInt(document.getElementById('custom-h').value) || canvas.getHeight();
      setCanvasSize(w, h);
    });

    // upload background image
    document.getElementById('bgfile').addEventListener('change', function(e){
      const file = e.target.files[0];
      if (!file) return;
      const reader = new FileReader();
      reader.onload = function(f){
        const data = f.target.result;
        fabric.Image.fromURL(data, function(img){
          // scale to fit the canvas while preserving aspect ratio
          const scaleX = canvas.getWidth() / img.width;
          const scaleY = canvas.getHeight() / img.height;
          const scale = Math.max(scaleX, scaleY); // cover
          img.set({ left: 0, top: 0, selectable: false });
          img.scaleToWidth(canvas.getWidth());
          img.scaleToHeight(canvas.getHeight());

          // remove previous background images (optional)
          const prev = canvas.getObjects('image').filter(o => !o.selectable);
          prev.forEach(p => canvas.remove(p));

          canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas));
        });
      };
      reader.readAsDataURL(file);
    });

    // add text
    document.getElementById('add-text').addEventListener('click', () => {
      const text = new fabric.IText('New menu item', {
        left: 50,
        top: 50,
        fontFamily: 'Arial',
        fontSize: 36,
        fill: '#000000',
      });
      canvas.add(text).setActiveObject(text);
    });

    // delete selected with Delete key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Delete' || e.key === 'Backspace') {
        const obj = canvas.getActiveObject();
        if (obj) canvas.remove(obj);
      }
    });

    // download JPG (client-side)
    document.getElementById('download').addEventListener('click', () => {
      // convert to JPEG with white background (optional)
      const origBg = canvas.backgroundColor;

      // create a temporary clone to flatten objects onto white background
      const dataURL = canvas.toDataURL({ format: 'jpeg', quality: 0.92 });

      const link = document.createElement('a');
      link.href = dataURL;
      link.download = 'menucard.jpg';
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    });

    // Save to server
    document.getElementById('save-server').addEventListener('click', async () => {
      try {
        const dataURL = canvas.toDataURL({ format: 'jpeg', quality: 0.92 });
        const resp = await fetch("{{ route('menucard.save') }}", {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({ image: dataURL })
        });
        const json = await resp.json();
        if (resp.ok) {
          alert('Saved on server: ' + json.url);
        } else {
          alert('Save failed: ' + (json.error || resp.statusText));
        }
      } catch (err) {
        alert('Save error: ' + err.message);
      }
    });
  </script>
</body>
</html>