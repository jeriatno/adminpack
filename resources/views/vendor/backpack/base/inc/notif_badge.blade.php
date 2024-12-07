{{--Notification badge on sidebar--}}

<style>
    .notif-badge {
        background-color: #d9534f;
        color: #fff;
        display: inline-block;
        padding: 2px 6px;
        font-size: .7em;
        border-radius: 100%;
    }
</style>

<script>
    /**
     * Define module var as constants
     */
    const PIPELINE_CHANNEL = 'pipeline-channel-header'
    const PO_BOOKING = 'forward-order'
    const PRINCIPAL_CLAIM = 'principal-claim'
    const RENT_STOCK_SPPB = 'request-sppb'

    /**
     * Init function
     */

    notificationPNMIT()

    function notificationPNMIT() {
        $.ajax({
            url: "{{ backpack_url('partnumber/mit/notification') }}",
            method: 'get',
            success: function (res) {
                $("#pnMitApproval").html("Pending Approval " + res.approval)
                $("#pnMitComplete").html("Pending Complete " + res.complete)
                $("#pnMitHeader").html("MIT Material " + res.header)
            }
        });
    }

    /**
     * Notification badges
     */
    var NotifBadgeComponent = (function () {
        function setNotifBadge(module, type, count) {
            const badgeSelector = type ? `#${module}-${type}-badge` : `#${module}-badge`;

            if (count === 0) {
                $(badgeSelector).removeClass('notif-badge');
            } else {
                $(badgeSelector).text(count);
            }
        }

        function getNotifBadge(module) {
            let url = module+'/notif-badge';
            if(module === RENT_STOCK_SPPB) {
                url = 'rent-stock/'+ module +'/notif-badge';
            }

            $.ajax({
                url: `{{ backpack_url() }}/`+url,
                type: 'GET',
                success: function (response) {
                    setNotifForModule(module, response);
                },
                error: function (error) {
                    console.error('Error fetching notification:', error);
                }
            });
        }

        function getNotifBadges() {
            $.ajax({
                url: `{{ url('notification/notif-badges') }}`,
                type: 'GET',
                success: function (response) {
                    setNotifForModule('ALL', response);
                },
                error: function (error) {
                    console.error('Error fetching notifications:', error);
                }
            });
        }

        /**
         * Set your role module here..
         */
        function setNotifForModule(module, response) {
            let res = response.data

            if (module === PIPELINE_CHANNEL) {
            }

            if (module === PO_BOOKING) {
                setNotifBadge(module, 'all', res.notif_for_all);
                setNotifBadge(module, 'requester', res.notif_for_requester);
                setNotifBadge(module, 'product-manager', res.notif_for_product_manager);
                setNotifBadge(module, 'division-manager', res.notif_for_division_manager);
                setNotifBadge(module, 'director', res.notif_for_director);
                setNotifBadge(module, 'sales-admin', res.notif_for_sales_admin);
                setNotifBadge(module, 'purchase-admin', res.notif_for_purchase_admin);
            }

            if (module === PRINCIPAL_CLAIM) {
                setNotifBadge(module, 'all', res.notif_for_all);
                setNotifBadge(module, 'requester', res.notif_for_requester);
                setNotifBadge(module, 'accounting', res.notif_for_accounting_admin);
                setNotifBadge(module, 'tax-admin', res.notif_for_tax_admin);
                setNotifBadge(module, 'product-admin', res.notif_for_product_admin);
            }

            if (module === RENT_STOCK_SPPB) {
                setNotifBadge(module, 'all', res.notif_count);
            }

            if (module === 'ALL') {
                setNotifBadge(PIPELINE_CHANNEL, '', res.pipeline);
                setNotifBadge(PO_BOOKING, '', res.po_booking);
                setNotifBadge(PRINCIPAL_CLAIM, '', res.principal_claim);
                setNotifBadge(RENT_STOCK_SPPB, '', res.rent_stock_sppb);
            }
        }

        return {
            forModule: getNotifBadge,
            forAllModule: getNotifBadges
        };
    })();

    /**
     * Even handler
     */

    $(function () {
        // all
        NotifBadgeComponent.forAllModule()

        // pipeline
        // $('#pipelineMenu').click(function () {
        //    NotifBadgeComponent.forModule(PIPELINE_CHANNEL)
        // })

        // po booking
        $('#forwardOrderMenu').click(function () {
            NotifBadgeComponent.forModule(PO_BOOKING)
        })

        // principal claim
        // $('#principalClaimMenu').click(function () {
        //    NotifBadgeComponent.forModule(PRINCIPAL_CLAIM)
        // })

        /*
            check current url
         */

        let currentURL = window.location.pathname;

        // pipeline
        // if (currentURL.indexOf('/admin/'+PIPELINE_CHANNEL) === 0) {
        //     NotifBadgeComponent.forModule(PIPELINE_CHANNEL)
        // }

        // forward order
        if (currentURL.indexOf('/admin/'+PO_BOOKING) === 0) {
            NotifBadgeComponent.forModule(PO_BOOKING)
        }

        // principal claim
        if (currentURL.indexOf('/admin/'+PRINCIPAL_CLAIM) === 0) {
            NotifBadgeComponent.forModule(PRINCIPAL_CLAIM)
        }

        // rent stock
        if (currentURL.indexOf('/admin/rent-stock/'+RENT_STOCK_SPPB) === 0) {
            NotifBadgeComponent.forModule(RENT_STOCK_SPPB)
        }
    })

</script>
