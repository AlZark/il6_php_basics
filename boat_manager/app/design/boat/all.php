<div>
    <h1>My boats</h1>
</div>
<div>
    <?php foreach ($this->data['boats'] as $boat) {
        ; ?>
        <h3><?php echo $boat->getName(); ?></h3>
        <p>Model: <?php echo $boat->getModelId(); //TODO ?></p>
        <p>Type: <?php //echo $boat->getTypeId(); //TODO ?></p>
        <p>Length: <?php echo $boat->getLength() . 'm. Width: ' . $boat->getWidth() . 'm. Depth: ' . $boat->getDepth() . 'm.'; ?></p>

    <?php } ?>
    
</div>