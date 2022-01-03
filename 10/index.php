<?php
echo '<h4>Урок 10. Деревья, рекурсия</h4>';
echo '<hr>';
echo '1. Реализовать построение и обход дерева для математического выражения. <br>';
echo '<hr>';

// 1)
class Node 
{
    private $value;
    private $parent;
    private $left;
    private $right;

    public function __construct($value=null, $parent=null, $left=null, $right=null) 
    {
        $this->value = $value;
        $this->parent = $parent;
        $this->left = $left;
        $this->right = $right;
    }

    public function getValue()
    {
        return $this->value;
    }
    
    public function getParent()
    {
        return $this->parent;
    }

    public function getLeft()
    {
        return $this->left;
    }
    
    public function getRight()
    {
        return $this->right;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }
    
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    public function setLeft($left)
    {
        $this->left = $left;
    }
    
    public function setRight($right)
    {
        $this->right = $right;
    }
}

function buildTree($str) {
    $arr = explode(" ", $str);

    // echo '<pre>'; 
    // var_dump($arr); 
    // echo '</pre>';

    if (count($arr) == 0) return;

    if ($arr[0] !== '(' || $arr[count($arr)-1] !== ')') {
        array_unshift($arr, '(');
        array_push($arr, ')');
    }

    $operators = ['+','-','/','*'];
    $root = new Node();
    $current = $root;

    foreach ($arr as $value) {
        // Если считан токен '(' - добавляем новый узел, как левого потомка текущего, и спускаемся к нему вниз.
        // Если считанный один из элементов списка ['+','-','/','*'], то устанавливаем корневое значение текущего узла равным 
        // оператору из этого токена. Добавляем новый узел на место правого потомка текущего и спускаемся вниз по правому поддереву.
        // Если считанный токен - число, то устанавливаем корневое значение равным этой величине и возвращаемся к родителю.
        // Если считан токен ')', то перемещаемся к родителю текущего узла.
        if ($value == '(') {
            $newNode = new Node();
            $newNode->setParent($current);
            $current->setLeft($newNode);
            $current = $newNode; 
        }
        elseif (in_array($value, $operators)) {
            $current->setValue($value);
            $newNode = new Node();
            $newNode->setParent($current);
            $current->setRight($newNode);
            $current = $newNode; 
        }
        elseif (is_numeric($value)) {            
            $current->setValue($value);
            $current = $current->getParent();     
        }
        elseif ($value == ')') {
            // $parent = $current->getParent();
            // if ($parent == null) {
            //     $parent = new Node();
            //     $parent->setLeft($current);
            //     $current->setParent($parent);
            // }
            $current = $current->getParent();
        }
    }

    return $root;
}

function stringFromTree(Node $tree) {
    $root = getRoot($tree);

    // echo '<pre>'; 
    // var_dump($root); 
    // echo '</pre>';

    $str = '( ' . strFromNode($root->getLeft()) . ' ' . $root->getValue() . ' ' . strFromNode($root->getRight()) . ' )';

    return $str;
}

function getRoot(Node $tree) {
    $root = $tree;

    while ($root->getParent() !== null) {
        $root = $root->getParent();
    }

    return $root;
}

function strFromNode(Node $node) {
    $str = '';
    $left = $node->getLeft();
    $right = $node->getRight();
    $value = $node->getValue();

    if ($left !== null && $right !== null) {
        $str .= '( ' . strFromNode($left) . ' ' . $value . ' ' . strFromNode($right) . ' )';
    }
    elseif ($left !== null && $right === null) {
        $str .= strFromNode($left) . ' ' . $value . ' ';
    }
    elseif ($left === null && $right !== null) {
        $str .= ' ' . $value . ' ' . strFromNode($right);
    }
    elseif ($left === null && $right === null) {
        $str .= $value;
    }

    return $str;
}

function toTreeAndBack($str) {
    echo "Дано выражение: $str <br>";
    $tree = buildTree($str);    
    $stringFromTree = stringFromTree($tree);
    echo "Выражение из дерева: $stringFromTree <br><br>";
}

toTreeAndBack('1 + 2');
toTreeAndBack('( 1 + 2 )');
toTreeAndBack('3 - ( 4 * 5 )');
toTreeAndBack('( 3 - ( 4 * 5 ) )');
toTreeAndBack('( 4 / 5 ) + 3');
toTreeAndBack('( ( 4 / 5 ) + 3 )');
toTreeAndBack('( ( 4 * 5 ) - ( 3 / 2 ) )');