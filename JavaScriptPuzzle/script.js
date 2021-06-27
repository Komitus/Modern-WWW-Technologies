var rows = 4;
var columns = 4;
var puzzle;

var img_path = "images/original/img_10.jpg";
var submit_button = document.querySelector("#confirm-button");
var reset_button = document.querySelector("#reset-button");
var canvas = document.getElementById("canvas");
var gallleryImages = document.querySelectorAll(".gallery-img");

loadGame();

$(function () {
    let select_column = $("#column-size-select");
    let select_row = $("#row-size-select");
    for (i = 2; i <= 12; i++) {
        select_column.append($("<option></option>").val(i).html(i));
        select_row.append($("<option></option>").val(i).html(i));
    }

});

function imageExists(image_url) {

    var http = new XMLHttpRequest();

    http.open('HEAD', image_url, false);
    http.send();

    return http.status != 404;

}

function loadGame() {

    let p = new Promise((resolve, reject) => {

        let loaded = imageExists(img_path);

        if (loaded == true)
            resolve("Success");
        else
            reject("Img loading failed");

    });

    p.then((message) => {
        //console.log(message);
        initialize_canvas(img_path, rows, columns);
    }).catch((message) => {
        console.log("Catched error: " + message);
        canvas.getContext("2d").fillText("Couldn't load image!", canvas.width / 2 - 50, canvas.height / 2, 200)
    })
}

submit_button.addEventListener("click", () => {

    let select_row = document.querySelector("#row-size-select");
    let select_column = document.querySelector("#column-size-select");

    rows = select_row.options[select_row.selectedIndex].value;
    columns = select_column.options[select_column.selectedIndex].value;
    loadGame();
});

reset_button.addEventListener("click", () => {

    let resetPuzzle = new Puzzle(puzzle.rows, puzzle.columns, puzzle.img, puzzle.ctx);
    resetPuzzle.tiles = Array.from(puzzle.tilesAtStart);
    puzzle = resetPuzzle;
    puzzle.init_tiles();
    puzzle.draw_tiles();
});


var choosenImg = 0;
if (gallleryImages) {

    gallleryImages.forEach(function (image, index) {
        image.onclick = function () {

            gallleryImages[choosenImg].style.border = "none";
            var i;
            for (i = 0; i < gallleryImages.length; i++) {
                if (i != choosenImg && i != index)
                    break;
            }
            //let getElementCss = window.getComputedStyle(gallleryImages[i]);
            //let opacity = getElementCss.getPropertyValue("opacity");

            if (window.innerWidth > 700) {
                
                for (i = 0; i < gallleryImages.length; i++) {
                    gallleryImages[i].style.opacity = "0.3";
                }
                
            }
            else {
                for (i = 0; i < gallleryImages.length; i++) {
                    gallleryImages[i].style.opacity = "1.0";
                }
            }
            image.style.opacity = "1.0";
            image.style.border = "15px groove #520066";
            img_path = "images/original/img_" + (index + 1) + ".jpg";
            choosenImg = index;

        };
    });
}

function initialize_canvas(img_path, rows, columns) {

    canvas = document.getElementById("canvas");

    const img = new Image();
    img.src = img_path;
    var higlighted_tile = null;

    img.addEventListener("load", () => {
        canvas.width = img.width;
        canvas.height = img.height;
        var ctx = canvas.getContext("2d");
        puzzle = new Puzzle(rows, columns, img, ctx);
        puzzle.draw_tiles()

        function getCoords(canvas, event) {
            var rect = canvas.getBoundingClientRect()
            var x = (event.clientX - rect.left) * (canvas.width / rect.width);
            var y = (event.clientY - rect.top) * (canvas.height / rect.height);
            var coords = puzzle.getTileCoords(x, y);

            return coords;
        }

        canvas.addEventListener("click", event => {

            var coords = getCoords(canvas, event)

            if (puzzle.isMovable(coords)) {
                console.log("indexes: ", puzzle.getTileIndexByCoords(coords));
                puzzle.slide(puzzle.getTileIndexByCoords(coords))
                puzzle.draw_tiles(canvas)
                if (puzzle.checkWin()) {
                    puzzle.drawOnWin();
                    let winner = document.getElementById("winner-text");
                    winner.style.display = "block";
                    setTimeout(function () { winner.style.display = "none"; }, 4000);
                };
            }
        });

        canvas.addEventListener("mousemove", event => {

            var coords = getCoords(canvas, event)

            if (puzzle.isMovable(coords)) {
                if (higlighted_tile !== null)
                    puzzle.unHiglight(higlighted_tile.i, higlighted_tile.j);
                higlighted_tile = coords
                puzzle.higlightPuzzle(coords.i, coords.j);
            }
            else if (higlighted_tile !== null) {
                puzzle.unHiglight(higlighted_tile.i, higlighted_tile.j);
                higlighted_tile = null;
            }
        });
        canvas.addEventListener("mouseout", event => {

            if (higlighted_tile !== null) {
                puzzle.unHiglight(higlighted_tile.i, higlighted_tile.j);
                higlighted_tile = null;
            }
        });


    });
};



/*
*"i" is row, calculated by y/smth
*"j" is column, calculated by x/smth
*
*/
class Puzzle {
    constructor(rows, columns, img, ctx) {
        this.rows = rows;
        this.columns = columns;
        this.img = img;
        this.tile_height = img.height / rows;
        this.tile_width = img.width / columns;
        this.tilesAtStart = []
        this.tiles = []
        this.init_tiles();
        this.ctx = ctx;
    }

    init_tiles() {
        if (this.tiles.length == 0) {

            this.tiles.push(null);
            for (let i = 0; i < this.rows; i++) {
                for (let j = 0; j < this.columns; j++) {
                    if (i > 0 || j > 0) {
                        this.tiles.push(new Tile(j * this.tile_width, i * this.tile_height, i * this.columns + j));
                    }
                }
            }

            do {
                this.shuffleTiles();
            } while (!this.isSolvable())

        }
        this.tilesAtStart = Array.from(this.tiles);

    }

    shuffleTiles() {
        for (let i = this.tiles.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            if (i > 0 && j > 0)
                [this.tiles[i], this.tiles[j]] = [this.tiles[j], this.tiles[i]];
        }
    }

    draw_tiles() {
        this.ctx = canvas.getContext("2d");
        this.ctx.fillStyle = "#800000"
        this.ctx.fillRect(0, 0, canvas.width, canvas.height)
        for (let i = 0; i < this.rows; i++) {
            for (let j = 0; j < this.columns; j++) {
                let tile = this.tiles[i * this.columns + j]
                if (tile !== null) {
                    this.ctx.drawImage(
                        this.img, tile.sx, tile.sy,
                        this.tile_width + 0.3, this.tile_height + 0.3,
                        j * this.tile_width + 0.3, i * this.tile_height + 0.3,
                        this.tile_width - 0.3, this.tile_height - 0.3
                    )
                }
            }
        }
    }

    isMovable(coords) {
        const i = coords.i;
        const j = coords.j;
        const utileIndex = (i - 1) >= 0 ? (i - 1) * this.columns + j : undefined;
        const dtileIndex = (i + 1) < this.rows ? (i + 1) * this.columns + j : undefined;
        const ltileIndex = (j - 1) >= 0 ? (i * this.columns + (j - 1)) : undefined;
        const rtileIndex = (j + 1) < this.columns ? i * this.columns + (j + 1) : undefined;
        return [utileIndex, dtileIndex, ltileIndex, rtileIndex].includes(this.getBlankIndex());
    }

    getBlankIndex() {
        return this.tiles.findIndex(t => t === null);
    }

    getInvCount() {
        let inv_count = 0;
        for (let i = 0; i < this.tiles.length - 1; i++) {
            for (let j = i + 1; j < this.tiles.length; j++) {
                if (i > 0) {
                    if (this.tiles[i].id > this.tiles[j].id) inv_count++;
                }
            }
        }
        return inv_count;
    }

    //Then if N+e is even, the position is possible
    // e -  the row number of the empty square in my case: 0
    isSolvable() {
        let inv_count = this.getInvCount();
        //console.log(inv_count);
        if (inv_count > 0)
            return (this.getInvCount() % 2 == 0);
        else
            return false;
    }

    getTileCoords(x, y) {
        let i = parseInt(y / this.tile_height);
        let j = parseInt(x / this.tile_width);
        return { "i": i, "j": j };
    }

    getTileIndexByCoords(coords) {
        return coords.i * this.columns + coords.j;
    }

    slide(tileIndex) {
        if (this.tiles[tileIndex] === null) return;
        let blankIndex = this.getBlankIndex();
        this.tiles[blankIndex] = this.tiles[tileIndex];
        this.tiles[tileIndex] = null;
    }

    checkWin() {

        if (this.tiles[0] === null) {
            for (let i = 1; i < this.tiles.length; i++) {
                if (this.tiles[i].id != i) {
                    return false;
                }
            }
            return true;
        }
        else
            return false;
    }
    higlightPuzzle(row, column) {
        this.ctx.fillStyle = "rgb(95, 237, 0, 0.4)";
        this.ctx.fillRect(column * this.tile_width, row * this.tile_height, this.tile_width, this.tile_height);
    }
    unHiglight(row, column) {
        let tile = this.tiles[row * this.columns + column];
        if (tile !== null) {
            this.ctx.drawImage(
                this.img, tile.sx, tile.sy,
                this.tile_width, this.tile_height,
                column * this.tile_width, row * this.tile_height,
                this.tile_width, this.tile_height
            )
        }

    }
    drawOnWin() {
        this.ctx.drawImage(
            this.img, 0, 0,
            this.img.width, this.img.height,
            0, 0,
            this.img.width, this.img.height
        )
    }
}

class Tile {
    constructor(sx, sy, id) {
        this.sx = sx;
        this.sy = sy;
        this.id = id;
    }
}
