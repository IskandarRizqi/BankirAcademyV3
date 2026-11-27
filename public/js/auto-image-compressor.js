(function (window, document) {
    'use strict';

    var DEFAULT_MAX_BYTES = 1024 * 1024;
    var DEFAULT_DIMENSIONS = [1600, 1280, 1024, 800];
    var DEFAULT_QUALITIES = [0.82, 0.72, 0.62, 0.52, 0.42];
    var inputStates = new WeakMap();
    var formStates = new WeakMap();

    function isCompressible(file) {
        return file && ['image/jpeg', 'image/png', 'image/webp'].indexOf(file.type) !== -1;
    }

    function formatFileSize(bytes) {
        return (bytes / 1024 / 1024).toFixed(2) + ' MB';
    }

    function getMaxBytes(input) {
        var configured = parseInt(input.getAttribute('data-compress-max-bytes') || input.getAttribute('maxfilesize'), 10);

        return Number.isFinite(configured) && configured > 0 ? configured : DEFAULT_MAX_BYTES;
    }

    function getDimensions(input) {
        var configured = parseInt(input.getAttribute('data-compress-max-dimension'), 10);

        return Number.isFinite(configured) && configured > 0
            ? [configured, 1280, 1024, 800]
            : DEFAULT_DIMENSIONS;
    }

    function getStatusElement(input) {
        var selector = input.getAttribute('data-compression-status');

        if (selector) {
            return document.querySelector(selector);
        }

        var parent = input.parentElement;
        var status = parent && parent.querySelector('[data-image-compression-status]');

        if (!status && parent) {
            status = document.createElement('small');
            status.setAttribute('data-image-compression-status', 'true');
            status.setAttribute('aria-live', 'polite');
            status.className = 'form-text text-muted';
            input.insertAdjacentElement('afterend', status);
        }

        return status;
    }

    function setStatus(input, message, type) {
        var status = getStatusElement(input);

        if (!status) {
            return;
        }

        status.classList.remove('text-muted', 'text-success', 'text-danger');
        status.classList.add(type === 'error' ? 'text-danger' : type === 'success' ? 'text-success' : 'text-muted');
        status.textContent = message;
    }

    function updatePreview(input, file) {
        var selector = input.getAttribute('data-compression-preview');

        if (!selector || !file) {
            return;
        }

        var preview = document.querySelector(selector);

        if (!preview) {
            return;
        }

        var reader = new FileReader();
        reader.onload = function (event) {
            preview.src = event.target.result;
            preview.hidden = false;

            var containerSelector = input.getAttribute('data-compression-preview-container');
            var container = containerSelector ? document.querySelector(containerSelector) : null;
            if (container) {
                container.style.display = '';
            }
        };
        reader.readAsDataURL(file);
    }

    function setFormBusy(input, busy) {
        var form = input.form;

        if (!form) {
            return;
        }

        var state = formStates.get(form);

        if (!state) {
            state = { pending: 0, buttons: [] };
            formStates.set(form, state);
        }

        if (busy) {
            if (state.pending === 0) {
                state.failed = false;
                state.submitAfterCompression = false;
                state.buttons = Array.from(form.querySelectorAll('button[type="submit"], input[type="submit"]'))
                    .map(function (button) {
                        return { button: button, disabled: button.disabled };
                    });
            }

            state.pending += 1;
            state.buttons.forEach(function (item) {
                item.button.disabled = true;
            });
            return;
        }

        state.pending = Math.max(0, state.pending - 1);

        if (state.pending === 0) {
            state.buttons.forEach(function (item) {
                item.button.disabled = item.disabled;
            });
            state.buttons = [];

            if (state.submitAfterCompression && !state.failed) {
                state.submitAfterCompression = false;
                setTimeout(function () {
                    if (typeof form.requestSubmit === 'function') {
                        form.requestSubmit();
                    }
                }, 0);
            }
        }
    }

    function buildCompressedFile(file, maxBytes, dimensions) {
        if (!isCompressible(file) || file.size <= maxBytes) {
            return Promise.resolve(file);
        }

        return new Promise(function (resolve, reject) {
            var image = new Image();
            var objectUrl = URL.createObjectURL(file);
            var candidates = [];

            image.onload = function () {
                URL.revokeObjectURL(objectUrl);

                dimensions.forEach(function (dimension) {
                    var scale = Math.min(1, dimension / Math.max(image.width, image.height));
                    var canvas = document.createElement('canvas');
                    canvas.width = Math.max(1, Math.round(image.width * scale));
                    canvas.height = Math.max(1, Math.round(image.height * scale));

                    var context = canvas.getContext('2d');
                    context.fillStyle = '#ffffff';
                    context.fillRect(0, 0, canvas.width, canvas.height);
                    context.drawImage(image, 0, 0, canvas.width, canvas.height);

                    DEFAULT_QUALITIES.forEach(function (quality) {
                        candidates.push({ canvas: canvas, quality: quality });
                    });
                });

                function tryCandidate(index) {
                    if (index >= candidates.length) {
                        reject(new Error('Gambar terlalu besar untuk dikompres maksimal ' + formatFileSize(maxBytes) + '.'));
                        return;
                    }

                    var candidate = candidates[index];
                    candidate.canvas.toBlob(function (blob) {
                        if (!blob) {
                            tryCandidate(index + 1);
                            return;
                        }

                        if (blob.size <= maxBytes) {
                            resolve(new File([blob], file.name.replace(/\.[^/.]+$/, '') + '.jpg', {
                                type: 'image/jpeg',
                                lastModified: Date.now()
                            }));
                            return;
                        }

                        tryCandidate(index + 1);
                    }, 'image/jpeg', candidate.quality);
                }

                tryCandidate(0);
            };

            image.onerror = function () {
                URL.revokeObjectURL(objectUrl);
                reject(new Error('File gambar tidak dapat dibaca.'));
            };

            image.src = objectUrl;
        });
    }

    function assignFiles(input, files) {
        if (typeof DataTransfer === 'undefined') {
            throw new Error('Browser tidak mendukung penggantian file hasil kompresi.');
        }

        var dataTransfer = new DataTransfer();
        files.forEach(function (file) {
            dataTransfer.items.add(file);
        });
        input.files = dataTransfer.files;
    }

    function compressInput(input) {
        var files = Array.from(input.files || []);
        var compressibleFiles = files.filter(isCompressible);

        if (compressibleFiles.length === 0) {
            return Promise.resolve(files);
        }

        if (!compressibleFiles.some(function (file) { return file.size > getMaxBytes(input); })) {
            updatePreview(input, files[0]);
            setStatus(input, 'Ukuran: ' + formatFileSize(compressibleFiles.reduce(function (total, file) {
                return total + file.size;
            }, 0)), 'success');
            return Promise.resolve(files);
        }

        var state = inputStates.get(input) || { token: 0 };
        var token = ++state.token;
        inputStates.set(input, state);
        setFormBusy(input, true);
        setStatus(input, 'Mengompres gambar...', 'pending');

        return Promise.all(files.map(function (file) {
            return buildCompressedFile(file, getMaxBytes(input), getDimensions(input));
        })).then(function (compressedFiles) {
            if (state.token !== token) {
                return compressedFiles;
            }

            assignFiles(input, compressedFiles);
            updatePreview(input, compressedFiles[0]);
            var originalSize = files.reduce(function (total, file) { return total + file.size; }, 0);
            var compressedSize = compressedFiles.reduce(function (total, file) { return total + file.size; }, 0);

            setStatus(input, 'Ukuran: ' + formatFileSize(originalSize) + ' -> ' + formatFileSize(compressedSize), 'success');

            return compressedFiles;
        }).catch(function (error) {
            var formState = input.form && formStates.get(input.form);
            if (formState && state.token === token) {
                formState.failed = true;
            }

            if (state.token === token) {
                setStatus(input, error.message || 'Gambar gagal dikompres.', 'error');
            }

            throw error;
        }).finally(function () {
            setFormBusy(input, false);
        });
    }

    function isManualInput(input) {
        return input.getAttribute('data-auto-image-compress') === 'manual';
    }

    document.addEventListener('change', function (event) {
        var input = event.target.closest && event.target.closest('input[type="file"]');

        if (!input || isManualInput(input)) {
            return;
        }

        compressInput(input).catch(function () {
            // The status beside the input contains the actionable error.
        });
    });

    document.addEventListener('submit', function (event) {
        var form = event.target;
        var state = formStates.get(form);

        if (!state || state.pending === 0) {
            return;
        }

        event.preventDefault();
        state.submitAfterCompression = true;
    }, true);

    window.AutoImageCompressor = {
        compressInput: compressInput,
        compressFile: buildCompressedFile,
        isCompressible: isCompressible
    };
})(window, document);
