<script>
    // this is created by me
    function englishToBanlga(input){
        var number = String(input)
        var en = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9']
        var bn = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯']
        var empty = []

        var len = number.length;
        for(var i = 0; i < len; i++){
            empty.push(bn[number[i]])
        }
        return empty.join('')
    }
</script>
<img class="footer-image d-none d-sm-block" src="image/palm tree.svg" alt="tree palm">
<footer class="py-1">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <p class="mb-0 text-dark"><?php echo $copyright;?></p>
            </div>
        </div>
    </div>
</footer>
