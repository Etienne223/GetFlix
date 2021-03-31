<select id='select'>
            <?php 
            for ($i = 0; $i < 10; $i++) {
        ?>
                        <option value="<?php echo $movie_genres[$i];?>"><?php echo $movie_genres[$i];?></option>
                        <?php
                    }
                ?>
            </select>