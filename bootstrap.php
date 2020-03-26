<?php

foreach (glob("Model/*.php") as $filename) {
    include $filename;
}
