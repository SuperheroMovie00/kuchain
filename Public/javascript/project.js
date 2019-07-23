function trade_add_bind_card(_fid, _target) {
    let _this = $(_target);
    if(_this.attr("class") == "ico") {
        _this.parents("li").eq(0).find("ul").hide();
        _this.attr("class", "");
        _this.parents("li").eq(0).attr("class", "");
    } else {
        let _detail = _this.parents("li").eq(0).find("ul");
        if(_detail.size()>0) {
            _this.attr("class", "ico");
            _this.parents("li").eq(0).attr("class", "active");
            _detail.show();
        } else {
            let _data_id = _this.attr("data-id");
            let _data_type = _this.attr("data-type");
            let _url = "/Api/StoreCard/index";
            _url = _asr.addParam(_url, "func", _data_type);
            _url = _asr.addParam(_url, "id", _data_id);
            _asr.submit(_fid, _fid+"-Card", _url, 0, function(c) {
                _this.attr("class", "ico");
                _this.parents("li").eq(0).attr("class", "active");
                if(c == "") return false;
                _this.parents("li").eq(0).append(c);

                if(_this.parent().find("input[type=checkbox]").prop("checked")) {
                    let _p = _this.parents("li").eq(0);
                    _p.find("ul input[type=checkbox]").prop("checked", true);
                    _p.find("ul input[type=text]").each(function() {
                        $(this).val($(this).attr("default-weight"));
                        $(this).attr("readonly","readonly");
                    });
                }
                _asr.addListener(_fid, _this.parents("li").find("ul div em"), "click", trade_add_bind_card);
                _asr.addListener(_fid, _this.parents("li").find("ul div input[type=checkbox]"), "click", trade_add_check_card);
                _asr.addListener(_fid, _this.parents("li").find("ul div input[type=text]"), "blur", trade_add_calc);
                _asr.addListener(_fid, _this.parents("li").find("ul div  a.del"), "click", trade_add_removeCard);
            });
        }
    }
    return false;
}
function trade_add_check_card(_fid, _target) {
    let _dataType = _target.attr("data-type");
    let _dataParentId = _target.attr("data-parent-id");
    let _dataId = _target.attr("data-id");
    let _subType = "";
    let _parentType = "";
    if(_dataType == "card") {
        _subType = "package";
    } else if(_dataType == "package") {
        _subType = "buttress";
        _parentType = "card";
    } else if(_dataType == "buttress") {
        _parentType = "package";
    }
    if(_subType != "") {
        _target.parents("div.cardbox").find("input[type=checkbox][data-type="+_subType+"][data-parent-id="+_dataId+"]").prop("checked", _target.prop("checked"));
    }

    let _a = _target.parent().find("input[type=text]");
    if(_target.prop("checked")) {
        _a.attr("readonly","readonly");
        _a.val(_a.attr("default-weight"));
        if(_parentType != "") {
            _target.parents("div.cardbox ul.card-tree").find("input[type=checkbox][data-type="+_parentType+"][data-id="+_dataParentId+"]").prop("checked", true);
        }
        _target.parents("div.cardbox ul.card-tree").find("input[type=text][data-type="+_subType+"][data-parent-id="+_dataId+"]").each(function() {
            let _this = $(this);
            _this.attr("readonly","readonly");
            _this.val(_this.attr("default-weight"));
        });

        if(_dataType == "package") {
            let _p = _target.parents("div.cardbox ul.card-tree").find("input[type=text][data-type=card][data-id=" + _dataParentId + "]");
            _p.attr("readonly","readonly");
        } else if(_dataType == "buttress") {
            let _p = _target.parents("div.cardbox ul.card-tree").find("input[type=text][data-type=package][data-id=" + _dataParentId + "]");
            _p.attr("readonly","readonly");
            _dataParentId = _p.attr("data-parent-id");
            _p = _target.parents("div.cardbox ul.card-tree").find("input[type=text][data-type=card][data-id=" + _dataParentId + "]");
            _p.attr("readonly","readonly");
        }
    } else {
        _a.removeAttr("readonly");
        _a.val("");

        _target.parents("div.cardbox ul.card-tree").find("input[type=text][data-type="+_subType+"][data-parent-id="+_dataId+"]").each(function() {
            let _this = $(this);
            _this.removeAttr("readonly");
            _this.val("");
        });
        if(_target.parents("div.cardbox ul.card-tree").find("input[type=checkbox][data-type="+_dataType+"][data-parent-id="+_dataParentId+"]:checked").size() == 0) {
            _target.parents("div.cardbox ul.card-tree").find("input[type=checkbox][data-type="+_parentType+"][data-id="+_dataParentId+"]").prop("checked", false);
            let _p = _target.parents("div.cardbox ul.card-tree").find("input[type=text][data-type="+_parentType+"][data-id="+_dataParentId+"]");
            _p.removeAttr("readonly");
            _p.val("");
        }
    }

    if(_dataType == "card") {
        trade_add_calc_total_weight(_fid);
        return true;
    }

    trade_add_calc(_fid, _target);
}
function trade_add_calc(_fid, _target) {
    let _dataType = _target.attr("data-type");
    let _dataParentId = _target.attr("data-parent-id");
    let _dataId = _target.attr("data-id");
    //if(typeof(_dataParentId) == "undefined") return false;

    if(_target.attr("type") == "checkbox") {
        _target = _target.parent().find("input[type=text]");
    }

    let _childrenType = "";
    if(_dataType == "card") {
        _childrenType = "package";
    } else if(_dataType == "package") {
        _childrenType = "buttress";
    }
    let _w = 0;
    if(_childrenType != "" && typeof(_dataId) != "undefined") {
        let _children = _target.parents("ul").eq(0).find("input[type=text][data-type="+_childrenType+"][data-parent-id="+_dataId+"]");
        _children.each(function() {
            let _cw = $(this).val();
            _cw = parseFloat(_cw);
            if(isNaN(_cw)) _cw = 0;
            _w += _cw;
        });
        if(_children.size() > 0) {
            if(_w == 0) {
                _target.val("");
            } else {
                _target.val(_w.toFixed(3));
            }
        }
    }

    let _val = _target.val();
    let _defaultVal = _target.attr("default-weight");
    _val = parseFloat(_val);
    if(isNaN(_val)) _val = 0;
    _defaultVal = parseFloat(_defaultVal);
    if(isNaN(_defaultVal)) _defaultVal = 0;
    if(_val > _defaultVal) {
        _target.val(_defaultVal);
    }

    _w = 0;
    if(typeof(_dataParentId) != "undefined") {
        _target.parents("ul").find("input[type=text][data-type="+_dataType+"][data-parent-id="+_dataParentId+"]").each(function() {
            let _cw = $(this).val();
            _cw = parseFloat(_cw);
            if(isNaN(_cw)) _cw = 0;
            _w += _cw;
        });
    }

    if(_target.val() != "" && _target.val() != 0) {
        _target.parent().find("input[type=checkbox]").prop("checked", true);
    }
    let _parentType = "";
    if(_dataType == "buttress") {
        _parentType = "package";
    } else if(_dataType == "package") {
        _parentType = "card";
    } else {
        trade_add_calc_total_weight(_fid);
        return false;
    }
    let _targetParent = _target.parents("div.cardbox ul.card-tree").find("input[type=text][data-type="+_parentType+"][data-id="+_dataParentId+"]");
    if(_w == 0) {
        _targetParent.val("");
    } else {
        _targetParent.val(_w.toFixed(3));
    }

    if(_target.val() != "" && _target.val() != 0) {
        _targetParent.parent().find("input[type=checkbox]").prop("checked", true);
    }
    trade_add_calc(_fid, _targetParent);
}
function trade_add_calc_total_weight(_fid) {
    let _totalWeight = 0;
    $("#" + _fid + " div.cardbox ul.card-tree input[type=text][data-type=card]").each(function() {
        let _cardWeigth = $(this).val();
        _cardWeigth = parseFloat(_cardWeigth);
        if(isNaN(_cardWeigth)) _cardWeigth = 0;
        _totalWeight += _cardWeigth;
    });
    $("#" + _fid + " input[name=weight]").val(_totalWeight.toFixed(3));
    return false;
}
function trade_add_add_card(_fid, _target, _data) {
    let _url = "/Api/StoreCard/index";
    _url = _asr.addParam(_url, "func", "card");
    if(_data.hasOwnProperty("ids")) {
        _url = _asr.addParam(_url, "ids", _data.ids);
    } else {
        _url = _asr.addParam(_url, "id", _data.id);
    }
    if(_data.hasOwnProperty("storecard_type")) {
        _url = _asr.addParam(_url, "storecard_type", _data.storecard_type);
    } else {
        _url = _asr.addParam(_url, "storecard_type", 1);
    }

    _url = _asr.addParam(_url, "type", "html");
    _asr.submit(_fid, _fid + "-Card", _url, 0, function(c) {
        let _origCount = $("#"+_fid + " div.cardbox ul.card-tree li").size();
        $("#"+_fid + " div.cardbox ul.card-tree").append(c);
        let _newCount = $("#"+_fid + " div.cardbox ul.card-tree li").size();
        for(let i = _newCount;i > _origCount;i--) {
            _lastNode = $("#"+_fid + " div.cardbox ul.card-tree").find("li").eq(i - 1);
            if(_lastNode.size() == 0) return false;

            _asr.addListener(_fid, _lastNode.find("div em"), "click", trade_add_bind_card);
            _asr.addListener(_fid, _lastNode.find("div input[type=checkbox]"), "click", trade_add_check_card);
            _asr.addListener(_fid, _lastNode.find("div input[type=text]"), "blur", trade_add_calc);
        }
    });
    return false;
}
function trade_add_removeCard(_fid, _target) {
    _target.parents("li").eq(0).remove();
    trade_add_calc(_fid, $("#"+_fid + " div.cardbox ul.card-tree input[type=text]").eq(0));
    return false;
}
function trade_add_search_card(_fid, _target, _data) {
    let _url = "/Home/Trade/index?func=selectStoreCard";
    // let _goodsNo = _target.parents("div.screening").find("input[name=goods_no]");
    // if(_goodsNo.size() > 0) {
    //     _goodsNo = _goodsNo.eq(0).val();
    //     _url = _asr.addParam(_url, "goods_no", _goodsNo);
    // }
    _url = _asr.addParam(_url, "goods_no", _data.goods_no);
    _url = _asr.addParam(_url, "storecard_no", _data.storecard_no);
    _url = _asr.addParam(_url, "storecard_type", _data.storecard_type);
    _asr.popupFun(_url, '', '', function(_jsonData,_targetname, _tmpid, _pkey) {
        if(_jsonData.length == 0) {
            return false;
        }
        let _s = "";
        for(let i=0;i<_jsonData.length;i++) {
            if(_s == "") {
                _s = _jsonData[i].goods_name + "#" + _jsonData[i].materials;
            }
            if(_s != _jsonData[i].goods_name + "#" + _jsonData[i].materials) {
                _asr.message("错误", "不相同的商品名称和材质的商品不能一起开单");
                return false;
            }
        }
        let _ids = "";
        for(let i=0;i<_jsonData.length;i++) {
            if($("#" + _fid + " ul.card-tree input[type=checkbox][data-type=card][data-id="+_jsonData[i].id+"]").size() > 0) {
                continue;
            }
            if(i == 0) {
                $("#" + _fid + " input[name=goods_no]").val(_jsonData[i].goods_no);
                $("#" + _fid + " input[name=goods_name]").val(_jsonData[i].goods_name);
                $("#" + _fid + " label[name=materials]").html(_jsonData[i].materials);
                $("#" + _fid + " span[data-type=uom_weight]").html("重量/" + _jsonData[i].uom_weight);
            }

            if(_ids != "") _ids += ",";
            _ids += _jsonData[i].id;
        }
        trade_add_add_card(_fid, _target, {ids: _ids, storecard_type: _data.storecard_type});
        _asr.closePopup(_tmpid);
    });
    return false;
}

function trade_add_convert_capital_weight(_fid, _target) {
    let _uw = $("#"+_fid+" input[type=hidden][name=uom_weight]").val();
    if(_uw == "") _uw = "吨";
    let _w = _target.val();
    _w = parseFloat(_w);
    if(isNaN(_w)) {
        return false;
    }
    let _txt = _asr.convertCapital(_w.toString(), "点" ,_uw, "w");
    $("#"+_fid + " span[data-type=uom-weight-capital]").html("大写:"+_txt);
    return false;
}
function trade_add_convert_capital_amount(_fid, _target) {
    let _w = $("#"+_fid+" input[type=text][name=weight]").val();
    _w = parseFloat(_w);
    if(isNaN(_w)) {
        return false;
    }
    let _p = _target.val();
    _p = parseFloat(_p);
    if(isNaN(_p)) {
        return false;
    }

    let _txt = _asr.convertCapital((_w * _p).toString(), "元" ,"整", "rmb");
    $("#"+_fid + " span[data-type=capital-amount]").html("大写:"+_txt);
    $("#"+_fid + " label[data-type=amount]").html((_w * _p).toFixed(2));

    let _uw = $("#"+_fid+" input[type=hidden][name=uom_weight]").val();
    if(_uw == "") _uw = "吨";
    return false;
}

function trade_add_search_goods(_fid, _target) {
    return _asr.popup('Goods',_fid,_fid+'-Search','Single',function(_jsonData,_targetname, _tmpid, pkey) {
        let _b = $("#" + pkey);
        _b.find("input[name=goods_name]").val(_jsonData[0].name);
        _b.find("input[name=goods_no]").val(_jsonData[0].goods_no);
        _b.find("label[name=materials]").html(_jsonData[0].materials);
        _b.find("span[data-type=uom_weight]").html(_jsonData[0].uom_weight);
        _b.find("input[type=hidden][data-type=uom_weight]").val(_jsonData[0].uom_weight);
        _b.find("span[data-type=price-uom]").html("元/" + _jsonData[0].uom_weight);
        $(_target).parent().find(".txt-clear").show();
        $(_target).parent().find(".txt-search").hide();
        _asr.closePopup(_tmpid);
    });
}
function trade_add_search_buyer(_fid, _target) {
    return _asr.popupFun('/Home/Trade/index?func=selectCustomer', '', '',_target.parent().find('input[name=buyer_id]'), _target.parent().find('input[name=buyer_name]'));
}
function trade_add_search_company(_fid, _target) {
    return _asr.popup('Customer',_fid,_fid+'-Search','Single', $("#"+_fid).find('input[name=delivery_company]'), $("#"+_fid).find('input[name=delivery_company_name]'));
}
function trade_add_search_carinfo(_fid, _target) {
    return _asr.popup('CustomerDelivery',_fid,_fid+'-Search','multi', function(_jsonData,_targetname, _tmpid, pkey) {
        let carInfo = "";
        for(let i = 0;i<_jsonData.length;i++) {
            carInfo += (i+1).toString() + ".  ";
            carInfo += "车牌:" + _jsonData[i].carno + ", 驾驶员:" + _jsonData[i].contact + ", 身份证:" + _jsonData[i].idcard + ", 手机:" + _jsonData[i].phone + ", 备注:" + _jsonData[i].remarks;
            carInfo += "\r\n";
        }
        $("#"+_fid).find("textarea[name=delivery_carinfo]").html(carInfo);
        _asr.closePopup(_tmpid);
    });
}