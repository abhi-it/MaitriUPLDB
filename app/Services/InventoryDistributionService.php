<?php

namespace App\Services;
use Exception;

class InventoryDistributionService
{
    /**
     * Transfer stock between two inventories
     *
     * @throws Exception
     */
    

    public function aggregateStocks($stocks)
    {
        return $stocks
            ->groupBy(function ($row) {

                switch ($row->item_type) {

                    case 'species_semen':
                        return implode('|', [
                            $row->item_type,
                            $row->species_semen,
                            $row->breed_type,
                            $row->breed,
                            $row->semen_type,
                            $row->bull_id,
                        ]);

                    case 'container':
                        return implode('|', [
                            $row->item_type,
                            $row->container_capacity,
                        ]);

                    default:
                        return $row->item_type;
                }
            })
            ->map(function ($items) {

                $first = $items->first();

                return [
                    'item_type'          => $first->item_type,
                    'item_name'          => $first->item,
                    'species_semen'      => $first->species_semen,
                    'breed_type'         => $first->breed_type,
                    'breed'              => $first->breed,
                    'semen_type'         => $first->semen_type,
                    'bull_id'            => $first->bull_id,
                    'container_capacity' => $first->container_capacity,
                    'total_qty'          => $items->sum('quantity'),
                ];
            })
            ->values();
    }

    public function subtractStocks($parentStocks, $chileStocks)
    {
        // Index zone stocks by unique key
        $zoneIndex = $chileStocks->mapWithKeys(function ($item) {
            return [
                $this->stockKey($item) => $item['total_qty']
            ];
        });

        // Subtract quantities
        return $parentStocks->map(function ($adminItem) use ($zoneIndex) {

            $key = $this->stockKey($adminItem);

            $zoneQty = $zoneIndex[$key] ?? 0;

            $adminItem['remaining_qty'] = max(
                0,
                $adminItem['total_qty'] - $zoneQty
            );

            return $adminItem;
        });
    }

    private function stockKey($row)
    {
        switch ($row['item_type']) {

            case 'species_semen':
                return implode('|', [
                    $row['item_type'],
                    $row['species_semen'],
                    $row['breed_type'],
                    $row['breed'],
                    $row['semen_type'],
                    $row['bull_id'],
                ]);

            case 'container':
                return implode('|', [
                    $row['item_type'],
                    $row['container_capacity'],
                ]);

            default:
                return $row['item_type'];
        }
    }
}