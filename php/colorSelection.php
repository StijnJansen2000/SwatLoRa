<div id="colorSelection">
    <form method="post" action="php/changeColor.php">
        <?php
        $getColorQ=$conn->prepare('SELECT * FROM colors WHERE config_id=:conf');
        $getColorQ->execute(array(
            ':conf'=>$_SESSION['config_id']
        ));
        $getColorQ= $getColorQ->fetch(PDO:: FETCH_ASSOC);
        $lowest = $getColorQ['lowest'];
        $low = $getColorQ['low'];
        $medium = $getColorQ['medium'];
        $high = $getColorQ['high'];
        $highest = $getColorQ['highest'];


        //                        $lowest = $getColorQ['lowest'];
        $lowestFromSnr = $getColorQ['llFromSnr'];
        $lowestToSnr = $getColorQ['llToSnr'];
        $lowestFromRSSI = $getColorQ['llFromRssi'];
        $lowestToRssi = $getColorQ['llToRssi'];
        $lowestSnrRange = $getColorQ['snrLowest'];
        $lowestRssiRange = $getColorQ['rssiLowest'];

        //                        $low = $getColorQ['low'];
        $lowFromSnr = $getColorQ['lFromSnr'];
        $lowToSnr = $getColorQ['lToSnr'];
        $lowFromRSSI = $getColorQ['lFromRSSI'];
        $lowToRssi = $getColorQ['lToRSSI'];
        $lowSnrRange = $getColorQ['snrLow'];
        $lowRssiRange = $getColorQ['rssiLow'];

        //                        $med = $getColorQ['medium'];
        $medFromSnr = $getColorQ['mFromSnr'];
        $medToSnr = $getColorQ['mToSnr'];
        $medFromRSSI = $getColorQ['mFromRssi'];
        $medToRssi = $getColorQ['mToRssi'];
        $medSnrRange = $getColorQ['snrMed'];
        $medRssiRange = $getColorQ['rssiMed'];

        //                        $high = $getColorQ['high'];
        $highFromSnr = $getColorQ['hFromSnr'];
        $highToSnr = $getColorQ['hToSnr'];
        $highFromRSSI = $getColorQ['hFromRssi'];
        $highToRssi = $getColorQ['hToRssi'];
        $highSnrRange = $getColorQ['snrHigh'];
        $highRssiRange = $getColorQ['rssiHigh'];

        //                        $highest = $getColorQ['highest'];
        $highestFromSnr = $getColorQ['hhFromSnr'];
        $highestToSnr = $getColorQ['hhToSnr'];
        $highestFromRSSI = $getColorQ['hhFromRssi'];
        $highestToRssi = $getColorQ['hhToRssi'];
        $highestSnrRange = $getColorQ['snrHighest'];
        $highestRssiRange = $getColorQ['rssiHighest'];

        ?>
        <h2>Color Selection:</h2>
        Lowest :<div class="color-picker"></div>
        <script>
            let lowestColor = '<?= $lowest ?>';

            const pickr = Pickr.create({
                el: '.color-picker',
                theme: 'classic', // or 'monolith', or 'nano'
                default: '#<?= $lowest ?>',

                components: {
                    // Main components
                    preview: true,
                    opacity: true,
                    hue: true,

                    // Input / output Options
                    interaction: {
                        hex: true,
                        input: true,
                        clear: true,
                        save: true
                    }
                }
            });
            pickr.on('save' , (...args) =>{
                lowestColor = args[0].toHEXA().toString();
            });

        </script>
        <br>
        <div class="form-row" style="margin-left: 100px">
            SNR From:
            <div class="form-group col-md-2">
                <input type="text" class="form-control" name="LowestSnrFrom" id="LowestSnrFrom" value="<?=$lowestFromSnr?>" maxlength="3">
            </div>
            SNR To:
            <div class="form-group col-md-2">
                <input type="text" class="form-control" name="LowestSnrTo" id="LowestSnrTo" value="<?=$lowestToSnr?>" maxlength="3">
            </div>
            SNR Lowest Range:
            <div class="form-group col-md-2">
                <input type="text" class="form-control" name="LowestSnrRange" id="LowestSnrRange" value="<?=$lowestSnrRange?>" maxlength="4">
            </div>
        </div>
        <div class="form-row" style="margin-left: 100px">
            RSSI From:
            <div class="form-group col-md-2">
                <input type="text" class="form-control" name="LowestRSSIFrom" id="LowestRSSIFrom" value="<?=$lowestFromRSSI?>" maxlength="3">
            </div>
            RSSI To:
            <div class="form-group col-md-2">
                <input type="text" class="form-control" name="LowestRssiTo" id="LowestRssiTo" value="<?=$lowestToRssi?>" maxlength="3">
            </div>
            RSSI Lowest Range:
            <div class="form-group col-md-2">
                <input type="text" class="form-control" name="LowestRssiRange" id="LowestRssiRange" value="<?=$lowestRssiRange?>" maxlength="4">
            </div>
        </div>
        Low :<div class="color-picker2"></div>
        <script>
            let lowColor = '<?= $low ?>';

            const pickr2 = Pickr.create({
                el: '.color-picker2',
                theme: 'classic', // or 'monolith', or 'nano'
                default: '#<?= $low ?>',

                components: {
                    // Main components
                    preview: true,
                    opacity: true,
                    hue: true,

                    // Input / output Options
                    interaction: {
                        hex: true,
                        input: true,
                        clear: true,
                        save: true
                    }
                }
            });
            pickr2.on('save' , (...args) =>{
                lowColor = args[0].toHEXA().toString();
            });
        </script>
        <br>
        <div class="form-row" style="margin-left: 100px">
            SNR From:
            <div class="form-group col-md-2">
                <input type="text" class="form-control" name="LowSnrFrom" id="LowSnrFrom" value="<?=$lowFromSnr?>" maxlength="3">
            </div>
            SNR To:
            <div class="form-group col-md-2">
                <input type="text" class="form-control" name="LowSnrTo" id="LowSnrTo" value="<?=$lowToSnr?>" maxlength="3">
            </div>
            SNR Low Range:
            <div class="form-group col-md-2">
                <input type="text" class="form-control" name="LowSnrRange" id="LowSnrRange" value="<?=$lowSnrRange?>" maxlength="4">
            </div>
        </div>
        <div class="form-row" style="margin-left: 100px">
            RSSI From:
            <div class="form-group col-md-2">
                <input type="text" class="form-control" name="LowRSSIFrom" id="LowRSSIFrom" value="<?=$lowFromRSSI?>" maxlength="3">
            </div>
            RSSI To:
            <div class="form-group col-md-2">
                <input type="text" class="form-control" name="LowRssiTo" id="LowRssiTo" value="<?=$lowToRssi?>" maxlength="3">
            </div>
            RSSI Low Range:
            <div class="form-group col-md-2">
                <input type="text" class="form-control" name="LowRssiRange" id="LowRssiRange" value="<?=$lowRssiRange?>" maxlength="4">
            </div>
        </div>
        Medium :<div class="color-picker"></div>
        <script>
            let mediumColor = '<?= $medium ?>';

            const pickr3 = Pickr.create({
                el: '.color-picker',
                theme: 'classic', // or 'monolith', or 'nano'
                default: '#<?= $medium ?>',

                components: {
                    // Main components
                    preview: true,
                    opacity: true,
                    hue: true,

                    // Input / output Options
                    interaction: {
                        hex: true,
                        input: true,
                        clear: true,
                        save: true
                    }
                }
            });

            pickr3.on('save' , (...args) =>{
                mediumColor = args[0].toHEXA().toString();
            });
        </script>
        <br>
        <div class="form-row" style="margin-left: 100px">
            SNR From:
            <div class="form-group col-md-2">
                <input type="text" class="form-control" name="MedSnrFrom" id="MedSnrFrom" value="<?=$medFromSnr?>"maxlength="3">
            </div>
            SNR To:
            <div class="form-group col-md-2">
                <input type="text" class="form-control" name="MedSnrTo" id="MedSnrTo" value="<?=$medToSnr?>" maxlength="3">
            </div>
            SNR Medium Range:
            <div class="form-group col-md-2">
                <input type="text" class="form-control" name="MedSnrRange" id="MedSnrRange" value="<?=$medSnrRange?>" maxlength="4">
            </div>
        </div>
        <div class="form-row" style="margin-left: 100px">
            RSSI From:
            <div class="form-group col-md-2">
                <input type="text" class="form-control" name="MedRSSIFrom" id="MedRSSIFrom" value="<?=$medFromRSSI?>" maxlength="3">
            </div>
            RSSI To:
            <div class="form-group col-md-2">
                <input type="text" class="form-control" name="MedRssiTo" id="MedRssiTo" value="<?=$medToRssi?>" maxlength="3">
            </div>
            RSSI Medium Range:
            <div class="form-group col-md-2">
                <input type="text" class="form-control" name="MedRssiRange" id="MedRssiRange" value="<?=$medRssiRange?>" maxlength="4">
            </div>
        </div>

        High :<div class="color-picker"></div>
        <script>
            let highColor = '<?= $high ?>';
            const pickr4 = Pickr.create({
                el: '.color-picker',
                theme: 'classic', // or 'monolith', or 'nano'
                default: '#<?= $high ?>',

                components: {
                    // Main components
                    preview: true,
                    opacity: true,
                    hue: true,

                    // Input / output Options
                    interaction: {
                        hex: true,
                        input: true,
                        clear: true,
                        save: true
                    }
                }
            });
            pickr4.on('save' , (...args) =>{
                highColor = args[0].toHEXA().toString();
            });
        </script>
        <br>
        <div class="form-row" style="margin-left: 100px">
            SNR From:
            <div class="form-group col-md-2">
                <input type="text" class="form-control" name="HighSnrFrom" id="HighSnrFrom" value="<?=$highFromSnr?>" maxlength="3">
            </div>
            SNR To:
            <div class="form-group col-md-2">
                <input type="text" class="form-control" name="HighSnrTo" id="HighSnrTo" value="<?=$highToSnr?>" maxlength="3">
            </div>
            SNR High Range:
            <div class="form-group col-md-2">
                <input type="text" class="form-control" name="HighSnrRange" id="HighSnrRange" value="<?=$highSnrRange?>" maxlength="4">
            </div>
        </div>
        <div class="form-row" style="margin-left: 100px">
            RSSI From:
            <div class="form-group col-md-2">
                <input type="text" class="form-control" name="HighRssiFrom" id="HighRssiFrom" value="<?=$highFromRSSI?>" maxlength="3">
            </div>
            RSSI To:
            <div class="form-group col-md-2">
                <input type="text" class="form-control" name="HighRssiTo" id="HighRssiTo" value="<?=$highToRssi?>" maxlength="3">
            </div>
            RSSI High Range:
            <div class="form-group col-md-2">
                <input type="text" class="form-control" name="HighRssiRange" id="HighRssiRange" value="<?=$highRssiRange?>" maxlength="4">
            </div>
        </div>
        Highest :<div class="color-picker"></div>
        <script>
            let highestColor = '<?= $highest ?>';
            const pickr5 = Pickr.create({
                el: '.color-picker',
                theme: 'classic', // or 'monolith', or 'nano'
                default: '#<?= $highest ?>',

                components: {
                    // Main components
                    preview: true,
                    opacity: true,
                    hue: true,

                    // Input / output Options
                    interaction: {
                        hex: true,
                        input: true,
                        clear: true,
                        save: true
                    }
                }
            });
            pickr5.on('save' , (...args) =>{
                highestColor = args[0].toHEXA().toString();
            });
        </script>
        <br>
        <div class="form-row" style="margin-left: 100px">
            SNR From:
            <div class="form-group col-md-2">
                <input type="text" class="form-control" name="HighestSnrFrom" id="HighestSnrFrom" value="<?=$highestFromSnr?>" maxlength="3">
            </div>
            SNR To:
            <div class="form-group col-md-2">
                <input type="text" class="form-control" name="HighestSnrTo" id="HighestSnrTo"value="<?=$highestToSnr?>" maxlength="3">
            </div>
            SNR Highest Range:
            <div class="form-group col-md-2">
                <input type="text" class="form-control" name="HighestSnrRange" id="HighestSnrRange" value="<?=$highestSnrRange?>" maxlength="4">
            </div>
        </div>
        <div class="form-row" style="margin-left: 100px">
            RSSI From:
            <div class="form-group col-md-2">
                <input type="text" class="form-control" name="HighestRSSIFrom" id="HighestRSSIFrom" value="<?=$highestFromRSSI?>" maxlength="3">
            </div>
            RSSI To:
            <div class="form-group col-md-2">
                <input type="text" class="form-control" name="HighestRssiTo" id="HighestRssiTo" value="<?=$highestToRssi?>" maxlength="3">
            </div>
            RSSI Highest Range:
            <div class="form-group col-md-2">
                <input type="text" class="form-control" name="HighestRssiRange" id="HighestRssiRange" value="<?=$highestRssiRange?>" maxlength="4">
            </div>
        </div>


        <input type="hidden" name="lowest" id="lowest">
        <input type="hidden" name="low" id="low">
        <input type="hidden" name="medium" id="medium">
        <input type="hidden" name="high" id="high">
        <input type="hidden" name="highest" id="highest">

        <script>
            pickr.on('save', (...args) => {
                document.getElementById('lowest').value = lowestColor;
            });
            pickr2.on('save', (...args) => {
                document.getElementById('low').value = lowColor;
            });
            pickr3.on('save', (...args) => {
                document.getElementById('medium').value = mediumColor;
            });
            pickr4.on('save', (...args) => {
                document.getElementById('high').value = highColor;
            });
            pickr5.on('save', (...args) => {
                document.getElementById('highest').value = highestColor;
            });
        </script>

        <br>
        <input type="submit" name="SubmitButton" value="Save Changes" class="btn btn-primary"/>

    </form>
</div>