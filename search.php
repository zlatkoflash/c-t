<?php
RightForms::$SHOW_ALL_PRODUCTS = true;

class SearchOrders {

    public static function showSearchForm() {
        ?>
        <hr />
        <form action="<?php print SETTINGS::URL_TO_ADMIN_PAGE; ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="user_is_logged" value="yes" />
            <input type="hidden" name="CHEQUE_TYPE" value="<?php print Cheque::TYPE_LASER; ?>" />
            <input type="hidden" name="IS_FOR_SEARCH_FORM" value="yes it is" />
            <input type="hidden" name="admin_action" id="admin_action" value="<?php print PagesModerator::PAGE_ADMIN; ?>" />
            <!--<input type="submit" value="Search Existing Laser Orders" class="floatLEft">-->
        </form>
        <form action="<?php print SETTINGS::URL_TO_ADMIN_PAGE; ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="user_is_logged" value="yes" />
            <input type="hidden" name="CHEQUE_TYPE" value="<?php print Cheque::TYPE_MANUAL; ?>" />
            <input type="hidden" name="IS_FOR_SEARCH_FORM" value="yes it is" />
            <input type="hidden" name="admin_action" id="admin_action" value="<?php print PagesModerator::PAGE_ADMIN; ?>" />
            <!--<input type="submit" value="Search Existing Manual Orders" class="floatRight">-->
        </form>
        <div class="clearBoth"></div>
        <!--<hr />-->
        <div class="width300px margin__0___AUTO holderInputsForSearch" style="">
        <?php
        //print_r($_POST);
        $_POST["CHEQUE_TYPE"] = Cheque::TYPE_LASER;
        if (isset($_POST["CHEQUE_TYPE"])) {
            ?>
                <div class="holderRightParceForm">
                    <div class="titleRightForm">
                        Search by Date
                    </div>
                    <div class="holderRightParceForm___intoForm">
                        <div>
                            <div class="floatLEft">From:</div>
                            <div class="floatRight"><input type="text" id="searchDateFrom" /></div>
                            <div class="clearBoth"></div>
                        </div>
                        <div>
                            <div class="floatLEft">To:</div>
                            <div class="floatRight"><input type="text" id="searchDateTo" /></div>
                            <div class="clearBoth"></div>
                        </div>
                        <script>
                            //getDate is function for getting current date
                            $("#searchDateFrom").datepicker();
                            $("#ui-datepicker-div").css("font-size", "65%");
                            $("#searchDateTo").datepicker();
                            $("#ui-datepicker-div").css("font-size", "65%");
                        </script>
                        <div class="floatRight">
                            <input type="button" value="Search" onclick="SearchResultsViewer.SRV.start_search(SearchResultsViewer.SEARCH_BY_DATE);" />
                        </div>
                        <div class="clearBoth"></div>
                    </div>	
                </div>
                <div class="holderRightParceForm">
                    <div class="titleRightForm">
                        Search by Universal Input
                    </div>	
                    <div class="holderRightParceForm___intoForm">
                        <input type="text" id="searchUniversalInput" /> <input type="button" value="Search" onclick="SearchResultsViewer.SRV.start_search(true);" />
                    </div>
                </div>
                <div class="holderRightParceForm">
                    <div class="titleRightForm">
                        Order Number for Searching
                    </div>	
                    <div class="holderRightParceForm___intoForm">
                        <input type="text" id="orderNumberSearchingInput" />
                    </div>
                </div>
            <?php
            $cheque = new Cheque($_POST["CHEQUE_TYPE"]);
            $RightFObject = new RightForms($cheque);

            TaxesModerator::$TaxesModerator = new TaxesModerator();
            TaxesModerator::$TaxesModerator->init_html_editor();

            RightForms::$RF->showMe();
            ?>
                <div class="holderRightParceForm">
                    <div class="titleRightForm">Search By Order Total Amount</div>
                    <div class="holderRightParceForm___intoForm">
                        <!--
                        <div>
                            Sub Total:
                            <div>
                            </div>
                            <div class="clearBoth"></div>
                            <div class="floatRight">from:<input type="text" name="" value="0" />to:<input type="text" value="0" /></div>
                        </div>-->
                        <div class="">
                            Shipping:<div class="floatRight"><input class="alignCenter fontWeightBOLD" name="shippingAmountSearchInput" type="text" name="" value="0" />$</div>
                        </div>
                        <div class="clearBoth"></div>
                        <div>
                            Taxes:<div class="floatRight"><input class="alignCenter fontWeightBOLD" name="taxesAmountSearchInput" type="text" name="" value="0" />$</div>
                        </div>
                        <div class="clearBoth"></div>

                        <div>
                            <b>Grand Total:</b>
                            <div>
                                from:<div class="floatRight"><input class="alignCenter fontWeightBOLD" name="grandTotalSearchInputFrom" type="text" name="" value="0" />$</div>
                            </div>
                            <div class="clearBoth"></div>
                            <div>
                                to:<div class="floatRight"><input class="alignCenter fontWeightBOLD" name="grandTotalSearchInputTo" type="text" name="" value="0" />$</div>
                            </div>
                            <div class="clearBoth"></div>
                        </div>
                        <div class="floatRight">
                            <input type="button" value="Search By Order Amount" onclick="SearchResultsViewer.SRV.start_search(SearchResultsViewer.SEARCH_BY_ORDER_TOTAL_AMOUNT);" />
                        </div>
                    </div>
                    <div class="clearBoth"></div>
                </div>
            <?php
            RightForms::$RF->draw_Email_Discount_Code();
            if ($_POST["CHEQUE_TYPE"] == Cheque::TYPE_LASER) {
                
            } else {
                
            }
            ?>
                <style>
                    .search_result_row
                    {
                        /*border:solid #CCC 1px;*/
                    }
                    .search_result_row:hover
                    {
                        border-color:#333;
                        color:#000;
                        background-color:#CCC;
                    }
                    .tableHeader
                    {
                        background-color:#09F;
                    }
                    .top_cells_for_sorting
                    {
                    }
                    .top_cells_for_sorting:hover
                    {
                        background-color:#6CF;
                        cursor:pointer;
                    }
                    .column_search_result{padding:3px;}
                    .sizeBTnSearchNavigation
                    {
                        width:19px;
                        height:23px;
                        cursor:pointer;
                    }
                </style>
                <script>
            $(".holderRightParceForm___intoForm").addClass("displayNone");
            /*
             I am hidding order form, and instead for that form, i will use input based form.
             */
            $(".orderTotalAmount").addClass("displayNone");
            $(".btnORDERCHEQUE").addClass("displayNone");
            $(document).ready(function(e)
            {
                var showHideTheForms = function()
                {
                    var form = $($(this).parent()).find(".holderRightParceForm___intoForm").get(0);
                    if ($(form).is(".displayNone"))
                    {
                        $(form).removeClass("displayNone");
                        SearchResultsViewer.SRV.prepareInputsForSearch(form, SearchResultsViewer.USE_FOR_SEARCH);
                    }
                    else
                    {
                        $(form).addClass("displayNone");
                        SearchResultsViewer.SRV.prepareInputsForSearch(form, SearchResultsViewer.DO_NOT_USE_FOR_SEARCH);
                    }
                }
                $(".titleRightForm").click(showHideTheForms);
                $(".subTitleRightForm").click(showHideTheForms);
                $(".titleRightForm").addClass("cursorPointer");
                $(".subTitleRightForm").addClass("cursorPointer");
                for (var i = 0; i < $(".holderInputsForSearch").find("input").length; i++)
                {
                    if ($($(".holderInputsForSearch").find("input").get(i)).attr("type") == ("hidden" || "text"))
                    {
                        $($(".holderInputsForSearch").find("input").get(i)).attr("value", "");
                    }
                }
                SearchResultsViewer.SRV.init_results_form();
                $(".btn_close_the_form").click(function()
                {
                    SearchResultsViewer.SRV.close_the_results();
                });
                $("#BSCombo_TYPE_BILLING").addClass("displayNone");
                $("#BSCombo_TYPE_SHIPING").addClass("displayNone");
            });
            $(window).resize(function()
            {
                SearchResultsViewer.SRV.resize();
            });
                </script>
                <hr />
                <div class="alignRight">
                    <input type="button" value="Go Search" 
                           onclick="SearchResultsViewer.SRV.start_search();" />
                </div>
                <script>
                                function SearchResultsViewer()
                                {
                                    this.rowWidth = 200;
                                    this.allVariables = [<?php print SearchTool::ALL_VARIABLES_FOR_JAVASCRIPT(); ?>];
                                    this.orders_result = [];
                                    this.orders_result_pow = [];
                                    this.order_by = "";
                                    this.order_type = "";
                                    this.totalWidth = function()
                                    {
                                        return this.countVisibleColumns() * $(".column_search_result").innerWidth();
                                    }
                                    this.countVisibleColumns = function() {
                                        return this.allVariables.length - this.countRemovedColumns;
                                    }
                                    this.countRemovedColumns = 0;
                                    this.rowsMaxCount = 30;
                                    this.currentPage = 0;

                                    this.optionsForPagesAreSetup = false;

                                    this.SELECTED_TYPE_OF_SEARCH = "";

                                    this.show_preloader = function()
                                    {
                                        $(".searchPreloaderHolder").removeClass("displayNone");
                                    }
                                    this.hide_preloader = function()
                                    {
                                        $(".searchPreloaderHolder").addClass("displayNone");
                                    }
                                    this.start_search = function(isForUniversal)
                                    {
                                        $("body").addClass("overflowHIDDEN");
                                        if (isForUniversal == null)
                                        {
                                            isForUniversal = false;
                                        }
                                        else if (isForUniversal == true)
                                        {
                                            this.SELECTED_TYPE_OF_SEARCH = true;
                                        }
                                        else if (isForUniversal == SearchResultsViewer.SELECTED_TYPE_OF_SEARCH)
                                        {
                                            isForUniversal = this.SELECTED_TYPE_OF_SEARCH;
                                        }
                                        else if (isForUniversal == SearchResultsViewer.SEARCH_BY_DATE)
                                        {
                                            this.SELECTED_TYPE_OF_SEARCH = SearchResultsViewer.SEARCH_BY_DATE;
                                            isForUniversal = SearchResultsViewer.SEARCH_BY_DATE;
                                        }
                                        else if (isForUniversal == SearchResultsViewer.SEARCH_BY_ORDER_TOTAL_AMOUNT)
                                        {
                                            this.SELECTED_TYPE_OF_SEARCH = SearchResultsViewer.SEARCH_BY_ORDER_TOTAL_AMOUNT;
                                            isForUniversal = SearchResultsViewer.SEARCH_BY_ORDER_TOTAL_AMOUNT;
                                        }
                                        this.show_preloader();
                                        $.post(settings.URL_TO_PHP_TOOLS,
                                                this.data_for_post(isForUniversal), function(data)
                                        {
                                            //alert(data);
                                            SearchResultsViewer.SRV.show_results(data);
                                        });
                                    }
                                    this.data_for_post = function(isForUniversal)
                                    {
                                        $(".search_form_results").removeClass("displayNone");
                                        $("#search_result_row_holder").html("");

                                        var data = {SEARCH_ORDERS_PLEASE: "true"};
                                        if (isForUniversal == true)
                                        {
                                            data["SEARCH_ORDERS_PLEASE_BY_UNIVERSAL"] = $("#searchUniversalInput").val();
                                        }
                                        else if (isForUniversal == SearchResultsViewer.SEARCH_BY_DATE)
                                        {
                                            data["SEARCH_BY_DATE"] = "Yes i will search";

                                            //getDate is function for getting current date
                                            /*
                                             $( "#searchDateFrom" ).datepicker();
                                             $("#ui-datepicker-div").css("font-size", "65%");
                                             $( "#searchDateTo" ).datepicker();
                                             $("#ui-datepicker-div").css("font-size", "65%");
                                             */
                                            var date;
                                            date = $("#searchDateFrom").datepicker("getDate");
                                            data["FROM_DATE"] = date.getTime();
                                            date = $("#searchDateTo").datepicker("getDate");
                                            data["TO_DATE"] = date.getTime();
                                        }
                                        else if (isForUniversal == SearchResultsViewer.SEARCH_BY_ORDER_TOTAL_AMOUNT)
                                        {
                                            data["SEARCH_BY_ORDER_TOTAL_AMOUNT"] = "Yes i will search.";
                                            data["shippingAmountSearchInput"] = $("#shippingAmountSearchInput").val();
                                            data["taxesAmountSearchInput"] = $("#taxesAmountSearchInput").val();
                                            data["grandTotalSearchInputFrom"] = $("#grandTotalSearchInputFrom").val();
                                            data["grandTotalSearchInputTo"] = $("#grandTotalSearchInputTo").val();
                                        }
                                        for (var i = 0; i < $(document).find("input").length; i++)
                                        {
                                            var input = $(document).find("input").get(i);
                                            if ($(input).attr("type") == "text" || $(input).attr("type") == "hidden")
                                            {
                                                //alert($(input).attr("USE_FOR_SEARCH"));
                                                if ($(input).attr("USE_FOR_SEARCH") == SearchResultsViewer.USE_FOR_SEARCH
                                                        && $(input).attr("value") != "")
                                                {
                                                    data[$(input).attr("name")] = $(input).attr("value");
                                                }
                                            }
                                        }
                                        /*
                                         variable for sorting the columns of the results
                                         */
                                        if (this.order_by != "")
                                        {
                                            data["order_by"] = this.order_by;
                                            data["order_type"] = this.order_type;
                                        }
                                        /*
                                         variable for searching by order number
                                         */
                                        if (document.getElementById("orderNumberSearchingInput").value != "")
                                        {
                                            //data["orderNumber"] = document.getElementById("orderNumberSearchingInput").value;
                                            data["orderNumberEdited"] = document.getElementById("orderNumberSearchingInput").value;
                                        }
                                        data["rowsMaxCount"] = this.rowsMaxCount;
                                        if (this.optionsForPagesAreSetup == true)
                                        {
                                            this.currentPage = $("#searchOptionsPages").val();
                                        }
                                        data["currentPage"] = this.currentPage;
                                        return data;
                                    }
                                    this.show_results = function(data)
                                    {
                                        this.hide_preloader();
                                        this.orders_result = [];
                                        this.orders_result_pow = [];
                                        var xmlData = $.parseXML(data);
                                        var xml = $($.parseXML(data)).find("orders").get(0);
                                        var totalHTML = "";
                                        for (var i = 0; i < $(xml).find("order").length; i++)
                                        {
                                            totalHTML += this.add_row($(xml).find("order").get(i), i);
                                            var order = $(xml).find("order").get(i);
                                            this.orders_result.push($($(order).find("orderNumber").get(0)).text());
                                            this.orders_result_pow.push($($(order).find("orderNumberEdited").get(0)).text());
                                        }
                                        $("#search_result_row_holder").html(totalHTML);
                                        $(".order_row_class").click(function()
                                        {
                                            var index = 0;
                                            for (var i = 0; i < $("#search_result_row_holder").find(".search_result_row").length; i++)
                                            {
                                                if ($(this).attr("class") ==
                                                        $($("#search_result_row_holder").find(".search_result_row").get(i)).attr("class"))
                                                {
                                                    index = i;
                                                    break;
                                                }
                                            }
                                            $("#fso_order_number").attr("value", SearchResultsViewer.SRV.orders_result[index]);
                                            if (confirm("Open Order " + SearchResultsViewer.SRV.orders_result_pow[index] + "?"))
                                            {
                                                document.getElementById("form_submit_order").submit();
                                            }
                                        });

                                        if (SearchResultsViewer.SRV.optionsForPagesAreSetup == false)
                                        {
                                            var totalPages = $(xmlData).find("countPages").text();
                                            $("#searchOptionsPages").find("option").remove();
                                            for (var i = 1; i <= totalPages; i++)
                                            {
                                                var valueFor = i - 1;
                                                $("#searchOptionsPages").append("<option value='" + valueFor + "'>" + i + "</option>");
                                            }
                                            SearchResultsViewer.SRV.optionsForPagesAreSetup = true;
                                        }
                                        var currPage = parseInt(this.currentPage) + 1;
                                        $("#searchPageOrderNumberCurr").html("Page " + currPage + " of " + $("#searchOptionsPages").find("option").length);
                                        this.resize();
                                    }
                                    this.add_row = function(orderxml, index)
                                    {
                                        var classBG = "";
                                        if (index % 2 == 0)
                                        {
                                            classBG = "bg_E9E9E9";
                                        }

                                        var totalHTML = '<div class="search_result_row ' + classBG + ' order_row_class identifire___' + index + '">';
                                        for (var i = 0; i < this.allVariables.length; i++)
                                        {
                                            var cellClass = ".cell__" + this.allVariables[i];
                                            if (this.all_hidded_columns[cellClass] == null)
                                            {
                                                var tekstForTheCell = $($(orderxml).find(this.allVariables[i]).get(0)).text();
                                                if (this.allVariables[i] == "date_modify")
                                                {
                                                    var date = new Date(parseInt(tekstForTheCell));
                                                    tekstForTheCell = date.toLocaleDateString();
                                                    tekstForTheCell += "<br/>" + date.toLocaleTimeString()
                                                }
                                                totalHTML += '<div class="floatLEft column_search_result cell__' + this.allVariables[i] + '">' +
                                                        tekstForTheCell
                                                        + ' </div>';
                                            }
                                            else
                                            {
                                                //this column is hidden
                                            }
                                        }
                                        totalHTML += '<div class="clearBoth"></div></div>';
                                        return totalHTML;
                                    }
                                    this.prepareInputsForSearch = function(form, useTheInputsOrNot)
                                    {
                                        for (var i = 0; i < $(form).find("input").length; i++)
                                        {
                                            $($(form).find("input").get(i)).attr("USE_FOR_SEARCH", useTheInputsOrNot);
                                        }
                                    }
                                    this.init_results_form = function()
                                    {
                                        $(".top_cells_for_sorting").click(function()
                                        {
                                            /*
                                             alert($(this).find(".arrowSortingSIZE").length);
                                             tableHeaderTitle.
                                             if($(document).find(".clicketColumnForSorting"))
                                                             
                                             if()
                                             {
                                             }*/
                                            if ($(document).find(".clickedCellHeader").length != 0)
                                            {
                                                var clickedHeader = $(document).find(".clickedCellHeader").get(0);
                                                if ($($(this).find(".tableHeaderTitle").get(0)).text() != $($(clickedHeader).find(".tableHeaderTitle").get(0)).text())
                                                {
                                                    $($(clickedHeader).find(".arrowSortingSIZE").get(0)).addClass("displayNone");
                                                    $($(clickedHeader).find(".arrowSortingSIZE").get(1)).addClass("displayNone");
                                                    $(clickedHeader).removeClass("clickedCellHeader");
                                                }
                                            }
                                            SearchResultsViewer.SRV.order_type = "ASC";
                                            if ($(this).is(".clickedCellHeader"))
                                            {
                                                if ($($(this).find(".arrowSortingSIZE").get(1)).is(".displayNone"))
                                                {
                                                    $($(this).find(".arrowSortingSIZE").get(0)).addClass("displayNone");
                                                    $($(this).find(".arrowSortingSIZE").get(1)).removeClass("displayNone");
                                                }
                                                else
                                                {
                                                    $($(this).find(".arrowSortingSIZE").get(0)).removeClass("displayNone");
                                                    $($(this).find(".arrowSortingSIZE").get(1)).addClass("displayNone");
                                                    SearchResultsViewer.SRV.order_type = "DESC";
                                                }
                                            }
                                            else
                                            {
                                                $($(this).find(".arrowSortingSIZE").get(1)).removeClass("displayNone");
                                                $(this).addClass("clickedCellHeader");
                                            }
                                            SearchResultsViewer.SRV.order_by = $($(this).find(".tableHeaderTitle").get(0)).text();
                                            SearchResultsViewer.SRV.start_search(  );
                                            //alert($($(this).find(".tableHeaderTitle").get(0)).text());
                                        });
                                        this.resize();
                                    }
                                    this.resize = function()
                                    {
                                        $(".search_form_results").css("height", $(window).innerHeight() + "px");
                                        $(".search_form_results_bg").css("width", $(document).innerWidth() + "px");
                                        $(".search_form_results_bg").css("height", $(window).innerHeight() + "px");
                                        //$(".search_form_results_bg").css("opacity", "0.5");
                                        $(".column_search_result").css("width", this.rowWidth + "px");
                                        //$(".search_form_results_holder").css("width", this.totalWidth()+"px");
                                        var cellHeight = $(".column_search_result").offsetParent().innerHeight() - 5;
                                        //$(".column_search_result").css("height", cellHeight+"px");
                                        //$(".relativeFormPositionHolderOfAllRows").css("width", $(document).innerWidth()+"px");
                                        //$(".relativeFormPositionHolderOfAllRows").css("height", $(document).innerHeight()+"px");
                                        //max height of the rows holder...
                                        //i do not add now because if there are for example 10 rows, bottom horizontal scrollbar is going to max bottom of the page and it need 
                                        //scrolling to down.
                                        /*
                                         $(".relativeFormPositionHolderOfAllRows").css("height", heightForTable+"px");
                                         var height = parseInt(heightForTable)-20;
                                         $(".search_result_row_holder").css("height", height+"px");
                                         */
                                        $("#search_result_row_holder").css("width", this.totalWidth() + "px");
                                        $(".tableHeader").css("width", this.totalWidth() + "px");


                                        $(".searchPreloaderHolder").css("width", $(document).innerWidth() + "px");
                                        $(".searchPreloaderHolder").css("height", $(window).innerHeight() + "px");
                                        $(".searchPreloaderBg").css("width", $(document).innerWidth() + "px");
                                        $(".searchPreloaderBg").css("height", $(window).innerHeight() + "px");
                                        $(".holderProgressSearchingTools").css("width", $(document).innerWidth() + "px");
                                        $(".holderProgressSearchingTools").css("height", $(window).innerHeight() + "px");

                                        var heightForTable = $(window).innerHeight() - $(".search_assets").innerHeight() - $(".tableHeaderHolder").innerHeight() - 5;
                                        $(".search_result_row_holderOVERFlow").css("height", heightForTable + "px");
                                    }
                                    this.close_the_results = function()
                                    {
                                        $(".search_form_results").addClass("displayNone");
                                        $("#search_result_row_holder").html("");
                                        $("body").removeClass("overflowHIDDEN");
                                    }
                                    this.all_hidded_columns = [];
                                    this.showHideColumn = function(variableName)
                                    {
                                        var cellClass = ".cell__" + variableName;
                                        if ($("#cb__" + variableName).is(":checked"))
                                        {
                                            $(cellClass).removeClass("displayNone");
                                            this.countRemovedColumns--;
                                            this.all_hidded_columns[cellClass] = null;
                                        }
                                        else
                                        {
                                            $(cellClass).addClass("displayNone");
                                            this.countRemovedColumns++;
                                            this.all_hidded_columns[cellClass] = "is not null";
                                        }
                                        $(".search_form_results_holder").css("width", this.totalWidth() + "px");
                                        this.resize();
                                    }
                                    this.gotoFirstPage = function()
                                    {
                                        $("#searchOptionsPages").prop("selectedIndex", 0);
                                        this.start_search(SearchResultsViewer.SELECTED_TYPE_OF_SEARCH);
                                    }
                                    this.back = function()
                                    {
                                        var selectedIndex = $("#searchOptionsPages").prop("selectedIndex") - 1;
                                        if (selectedIndex < 0) {
                                            selectedIndex = 0;
                                        }
                                        $("#searchOptionsPages").prop("selectedIndex", selectedIndex);
                                        this.start_search(SearchResultsViewer.SELECTED_TYPE_OF_SEARCH);
                                    }
                                    this.next = function()
                                    {
                                        var selectedIndex = $("#searchOptionsPages").prop("selectedIndex") + 1;
                                        if (selectedIndex >= $("#searchOptionsPages").find("option").length - 1)
                                        {
                                            selectedIndex = $("#searchOptionsPages").find("option").length - 1;
                                        }
                                        $("#searchOptionsPages").prop("selectedIndex", selectedIndex);
                                        this.start_search(SearchResultsViewer.SELECTED_TYPE_OF_SEARCH);
                                    }
                                    this.gotoLastPage = function()
                                    {
                                        var selectedIndex = $("#searchOptionsPages").find("option").length - 1;
                                        $("#searchOptionsPages").prop("selectedIndex", selectedIndex);
                                        this.start_search(SearchResultsViewer.SELECTED_TYPE_OF_SEARCH);
                                    }
                                }
                                SearchResultsViewer.SRV = new SearchResultsViewer();
                                SearchResultsViewer.USE_FOR_SEARCH = "USE_FOR_SEARCH";
                                SearchResultsViewer.DO_NOT_USE_FOR_SEARCH = "DO_NOT_USE_FOR_SEARCH";
                                SearchResultsViewer.SEARCH_BY_DATE = "SEARCH_BY_DATE";
                                SearchResultsViewer.SELECTED_TYPE_OF_SEARCH = "SELECTED_TYPE_OF_SEARCH";
                                SearchResultsViewer.SEARCH_BY_ORDER_TOTAL_AMOUNT = "SEARCH_BY_ORDER_TOTAL_AMOUNT";
                </script>
                <!--displayNone-->
                <div class="positionFixed width100Percent positionTopLeft search_form_results overflowAUTO bg_FFF displayNone">
                    <div class="search_assets">
                        <div class="bg_FFF">
                            <div class="width900PX margin__0___AUTO alignCenter">
                                Search Form Result <b class="cursorPointer btn_close_the_form">Close Search Result</b>
                            </div>
                        </div>
                        <div class="margin5px">
                            <div>
                                <!--Select columns to be visible-->
                            </div>
                            <div>
            <?php
            for ($i = 0; $i < count(OrdersDatabase::$arr_variables); $i++) {
                ?>
                                    <div class="floatLEft width180px lineTextHeight19">
                                        <input id="cb__<?php print OrdersDatabase::$arr_variables[$i]; ?>" 
                                               onclick="SearchResultsViewer.SRV.showHideColumn('<?php print OrdersDatabase::$arr_variables[$i]; ?>');" 
                                               checked="checked" type="checkbox" /><?php print OrdersDatabase::$arr_variables[$i]; ?>
                                    </div>
                <?php
            }
            ?>
                            </div>
                            <div class="clearBoth"></div>
                        </div>
                        <div>
                            <div class="padding10px">
                                <div>
                                    <div class="lineTextHeight22">
                                        <b>Select page</b>
                                        <select id="searchOptionsPages"><option>1</option><option>2</option><option>3</option></select>
                                        <b class="marginLeft5px cursorPointer" 
                                           onclick="SearchResultsViewer.SRV.start_search(SearchResultsViewer.SELECTED_TYPE_OF_SEARCH);">
                                            go to the selected page
                                        </b>
                                    </div>
                                    <div class="lineTextHeight23">
                                        <div>
                                            <div class="floatLEft lineTextHeight23"><b id="searchPageOrderNumberCurr">Page 1 of 100</b></div>
                                            <div class="sizeBTnSearchNavigation floatLEft navSearchGoToFirstPage" ></div>
                                            <div class="sizeBTnSearchNavigation floatLEft navSearchGoBack" ></div>
                                            <div class="sizeBTnSearchNavigation floatLEft navSearchGoNext" ></div>
                                            <div class="sizeBTnSearchNavigation floatLEft navSearchGoToTheLast" ></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearBoth"></div>
                            </div>
                            <script>
                                $(".sizeBTnSearchNavigation").mouseover(function()
                                {
                                    $(this).css("opacity", 1);
                                });
                                $(".sizeBTnSearchNavigation").mouseout(function()
                                {
                                    $(this).css("opacity", 0.5);
                                });
                                $(".sizeBTnSearchNavigation").css("opacity", 0.5);
                                $(".navSearchGoToFirstPage").click(function()
                                {
                                    SearchResultsViewer.SRV.gotoFirstPage();
                                });
                                $(".navSearchGoBack").click(function()
                                {
                                    SearchResultsViewer.SRV.back();
                                });
                                $(".navSearchGoNext").click(function()
                                {
                                    SearchResultsViewer.SRV.next();
                                });
                                $(".navSearchGoToTheLast").click(function()
                                {
                                    SearchResultsViewer.SRV.gotoLastPage();
                                });
                            </script>
                        </div>
                    </div>
                    <div class="positionRelative relativeFormPositionHolderOfAllRows bg_FFF ">
                        <!--<div class="bg_FFF search_form_results_bg positionAbsolute positionTopLeft"></div>-->
                        <div class="search_form_results_holder borderStyleSolid">

                            <!--tableHeader-->
                            <div class="tableHeaderHolder overflowHIDDEN">
                                <div class="tableHeader">
            <?php
            for ($i = 0; $i < count(OrdersDatabase::$arr_variables); $i++) {
                $classBGHeaderColor = "";
                if ($i % 2 != 0) {
                    $classBGHeaderColor = "bg_1796ea";
                }
                ?>
                                        <div class="floatLEft <?php print $classBGHeaderColor; ?> column_search_result top_cells_for_sorting cell__<?php print OrdersDatabase::$arr_variables[$i]; ?>">
                                            <div>
                                                <div class="floatLEft tableHeaderTitle"><?php print OrdersDatabase::$arr_variables[$i]; ?></div>
                                                <!---->
                                                <div class="floatRight arrowSortingSIZE arrowSortingNagore displayNone"> </div>
                                                <div class="floatRight arrowSortingSIZE arrowSortingNadolu displayNone"> </div>

                                                <!--<div class="clearBoth"></div>-->
                                            </div>
                                        </div>
                <?php
            }
            ?>
                                    <div class="clearBoth"></div>
                                </div>
                            </div>
                            <!--tableHeader-->

                            <!--holderRows-->
                            <div class="holderRows">

                                <div class="overflowAUTO search_result_row_holderOVERFlow borderStyleSolid" style="">

                                    <div id="search_result_row_holder">
            <?php
            for ($i = 0; $i < 100; $i++) {
                $classBG = "";
                if ($i % 2 == 0) {
                    $classBG = "";
                } else {
                    $classBG = "bg_E9E9E9";
                }
                ?>
                                            <!--search_result_row-->
                                            <div class="search_result_row <?php print $classBG; ?>">
                                            <?php
                                            for ($k = 0; $k < count(OrdersDatabase::$arr_variables); $k++) {
                                                $classBGCell = "";
                                                if ($i % 2 != 0) {
                                                    if ($k % 2 == 0) {
                                                        $classBGCell = "bg_F5F5F5";
                                                    } else {
                                                        
                                                    }
                                                } else {
                                                    if ($k % 2 != 0) {
                                                        $classBGCell = "bg_DADADA";
                                                    } else {
                                                        
                                                    }
                                                }
                                                ?>
                                                    <div class="floatLEft <?php print $classBGCell; ?> column_search_result cell__<?php print OrdersDatabase::$arr_variables[$k]; ?>">
                                                    <?php print OrdersDatabase::$arr_variables[$k]; ?>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                                <div class="clearBoth"></div>
                                            </div>
                                            <!--search_result_row-->

                                                <?php
                                            }
                                            ?>
                                    </div>

                                </div>

                            </div>
                            <!--holderRows-->
                            <script>
                                $(".search_result_row_holderOVERFlow").scroll(function()
                                {
                                    //alert($(this).scrollLeft());
                                    $(".tableHeaderHolder").scrollLeft($(this).scrollLeft());
                                });
                            </script>
                        </div>
                    </div>
                </div>

                <div class=" positionFixed searchPreloaderHolder positionTopLeft displayNone">
                    <div class="positionRelative">
                        <div class="positionAbsolute searchPreloaderBg bg_FFF">

                        </div>
                        <div class="positionAbsolute positionTopLeft holderProgressSearchingTools">
                            <div class="padding30px">
                                <div class="width126px margin__0___AUTO">Searching</div>
                                <div class="searchPreloader margin__0___AUTO"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    $(".searchPreloaderBg").css("opacity", 0.9);
                </script>
            <?php
        } else {
            
        }
        ?>
        </div>
        <?php
    }

}
?>