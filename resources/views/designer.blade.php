<x-layout title="Dashboard">
    <div class="content">
        <div class="row">
            <div class="col-lg-1">

                <div class="d-grid gap-2">
                    <label class="form-label mb-1">Tools</label>
                    <!-- Landscape -->
                    <button class="btn btn-secondary toolbox-btn" onclick="setLandscape()" title="Landscape">
                        <i class="bi bi-tablet-landscape"></i>
                    </button>

                    <!-- Portrait -->
                    <button class="btn btn-secondary toolbox-btn" onclick="setPortrait()" title="Portrait">
                        <i class="bi bi-tablet"></i>
                    </button>

                    <!-- Add Text -->
                    <button class="btn btn-secondary toolbox-btn" onclick="addTextBox()" title="Text Box">
                        <i class="bi bi-input-cursor-text"></i>
                    </button>

                    <!-- Add Background -->
                    <input type="file" id="bgInput" class="d-none" accept="image/*">
                    <label for="bgInput" class="btn btn-secondary toolbox-btn" title="Background">
                        <i class="bi bi-image-fill"></i>
                    </label>

                    <!-- Add Image -->
                    <input type="file" id="imgInput" accept="image/png, image/jpeg" style="display:none">
                    <button class="btn btn-secondary toolbox-btn" onclick="document.getElementById('imgInput').click()" title="Image">
                        <i class="bi bi-image-alt"></i>
                    </button>

                    <!-- Add Square -->
                    <button class="btn btn-secondary toolbox-btn" onclick="addSquare()" title="Square">
                        <i class="bi bi-square"></i>
                    </button>

                    <!-- Add Circle -->
                    <button class="btn btn-secondary toolbox-btn" onclick="addCircle()" title="Circle">
                        <i class="bi bi-circle"></i>
                    </button>

                </div>
            </div>

            <div class="col-lg-11">
                <div class="row g-3 align-items-end">

                    <!-- Font Family -->
                    <div class="col-md-2">
                        <label class="form-label mb-1">Font</label>
                        <select id="fontFamily" class="form-select">
                            <option value="Poppins">Poppins</option>
                            <option value="Inter">Inter</option>
                            <option value="Roboto">Roboto</option>
                            <option value="Montserrat">Montserrat</option>
                        </select>
                    </div>

                    <!-- Font Size -->
                    <div class="col-md-2">
                        <label class="form-label mb-1">Font Size</label>
                        <input type="number" id="fontSizePicker" class="form-control " min="10" max="200" value="42">
                    </div>

                    <!-- Color -->
                    <div class="col-md-1">
                        <label class="form-label mb-1">Color</label>
                        <input type="color" id="textColorPicker" class="form-control form-control-color" value="#000000">
                    </div>

                    <!-- Export Button -->
                    <div class="col-md-2">
                        <label class="form-label d-block mb-1">Export</label>
                        <button class="btn btn-secondary" onclick="downloadImage()" title="Export JPEG 1080p">
                            <i class="bi bi-send"></i> Export
                        </button>
                    </div>

                </div>

                <div class="canvas-wrapper">
                    <canvas id="responsive-canvas"></canvas>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/designer.js') }}"></script>
</x-layout>
